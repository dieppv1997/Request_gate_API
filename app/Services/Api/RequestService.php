<?php

namespace App\Services\Api;

use App\Contracts\Services\Api\RequestServiceInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\RequestRepository;
use App\Repositories\CommentRepository;
use App\Repositories\UserRepository;
use App\Services\AbstractService;
use App\Repositories\RequestHistoryRepository;
use Auth;
use Mail;
use Illuminate\Support\Facades\Config;
use App\Repositories\HistoryRepository;
use Carbon\Carbon;
use App\Jobs\SendEmail;
use App\Jobs\SendEmailUpdateRequest;

class RequestService extends AbstractService implements RequestServiceInterface
{
    /**
     * @var RequestServiceInterface
     */
    protected $requestRepository;

    /**
     * RequestService constructor.
     * @param RequestRepository $requestRepository
     * @param UserRepository $userRepository
     * @param CategoryRepository $categoryRepository
     * @param RequestHistoryRepository $requestHistoryRepository
     * @param HistoryRepository $historyRepository
     */
    public function __construct(
        RequestRepository $requestRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository,
        RequestHistoryRepository $requestHistoryRepository,
        HistoryRepository $historyRepository,
        CommentRepository $commentRepository
    ) {
        $this->requestRepository = $requestRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
        $this->requestHistoryRepository = $requestHistoryRepository;
        $this->historyRepository = $historyRepository;
        $this->commentRepository = $commentRepository;
    }

    /**
     * @param $params
     * @return array
     */
    public function index($params)
    {
        return $this->requestRepository->getListRequest($params)
            ->orderBy('created_at', 'DESC')
            ->orderBy('due_date', 'DESC')
            ->with('user:id,name', 'admin:id,name', 'category:id,name')
            ->paginate(Config::get('constant.pagination'));
    }
    public function store($params)
    {
        $data = [
            'title' => $params['title'],
            'category_id' => $params['category_id'],
            'user_id' => auth()->user()->id,
            'admin_id' => $params['admin_id'],
            'department_id' => auth()->user()->department_id,
            'status_admin' => Config::get('statuses.request_status.open'),
            'status_manager' => Config::get('statuses.request_status.open'),
            'content' => $params['content'],
            'due_date' => date("Y-m-d", strtotime($params['due_date'])),
            'priority' => $params['priority'],
        ];
        if ($this->categoryRepository
                ->find($data['category_id'])
                ->status === Config::get('statuses.request_status.disable')) {
            return ['message' => 'This category is disable',
                'code' => '401',
            ];
        }
        $request = $this->requestRepository->store($data);
        $contentToSendMail = $this->getContentToSendMail($request);
        $author = $contentToSendMail['email_author'];
        $assign = $contentToSendMail['email_assign'];
        $view = "create_request";
        $subject = "Create Request in Request Gate";
        $this->sendMail($contentToSendMail, $view, $subject, $author, $assign);
        return $request;
    }

    public function update($params, $id)
    {
        $user = $this->requestRepository->find($id);
        switch (Auth::user()->role_id) {
            case Config::get('role.admin'):
                return $this->updateRequestByAdmin($params, $user);
                break;
            case Config::get('role.manager'):
                return $this->updateRequestByManager($params, $user);
                break;
            default:
                return $this->updateRequestByUser($params, $user);
                break;
        }
    }

    public function destroy($id)
    {
        $user = $this->requestRepository->find($id);
        if ($this->isUserOfRequest($user)
            && $this->isOpenRequestStatus($user)) {
            $this->requestRepository->destroy($user);
            return [
                'code' => 200,
                'message' => 'You deleted successful'
            ];
        }
        return [
            'code' => 401,
            'message' => "You could not delete this request."
        ];
    }
    public function find($id)
    {
        $request = $this->requestRepository->find($id);
        return [
            'code' => '200',
            'id' => $request->id,
            'title' => $request->title,
            'content' => $request->content,
            'status_admin' => $request->status_admin,
            'status_manager' => $request->status_manager,
            'created' => $request->created_at->format('Y-m-d'),
            'category_id' => $request->category->id,
            'category' => $request->category->name,
            'assign' => $request->admin->name,
            'assign_id'=>$request->admin->id,
            'author' => $request->user->name,
            'due_date' => $request->due_date,
            'priority'=>$request->priority,
            'author_id' => $request->user->id,
            'department_id' => $request->department_id
        ];
    }

    public function getListToSearch()
    {
        return [
            'code'=>'200',
            'user' => $this->userRepository->getListAuthor()->get(),
            'admin' => $this->userRepository->getListAssignee()->get(),
            'category' => $this->categoryRepository->getListCategory()->get()
        ];
    }

    public function updateRequestByAdmin($params, $user)
    {
        $assignBefore = $user->admin->email;
        $data = $this->getData($params, $user);
        $historyRequest = $this->requestHistoryRepository->store($data);
        $newData = $this->insertHistory($historyRequest);
        $this->insertComment($historyRequest);
        $this->requestHistoryRepository->store($data);
        if (!empty($newData)) {
            $this->getDataAfterHandle($newData, $assignBefore);
        }
        return [
            'code' => 200,
            'data' => $user,
            'message' => 'success message'
        ];
    }

    public function updateRequestByManager($params, $user)
    {
        if ($this->isDepartment($user)) {
            $assignBefore = $user->admin->email;
            $data = $this->getData($params, $user);
            $historyRequest = $this->requestHistoryRepository->store($data);
            $newData = $this->insertHistory($historyRequest);
            $this->insertComment($historyRequest);
            if (!empty($newData)) {
                $this->getDataAfterHandle($newData, $assignBefore);
            }
            return [
                'code' => 200,
                'data' => $user,
                'message' => 'success message'
            ];
        }
        return [
            'code' => 401,
            'message' => "Author request does not belong to your department. You could not change this request"
        ];
    }

    public function updateRequestByUser($params, $user)
    {
        if ($this->isUserOfRequest($user)) {
            if ($this->isOpenRequestStatus($user)) {
                $assignBefore = $user->admin->email;
                $data = $this->getData($params, $user);
                $historyRequest = $this->requestHistoryRepository->store($data);
                $newData = $this->insertHistory($historyRequest);
                $this->insertComment($historyRequest);
                if (!empty($newData)) {
                    $this->getDataAfterHandle($newData, $assignBefore);
                }
                return [
                    'code' => 200,
                    'data' => $user,
                    'message' => 'success message'
                ];
            }
            return [
                'code' => 401,
                'message' => "Your request was received, You could not update request"
            ];
        }
        return [
            'code' => 401,
            'message' => "You are not Author of Request. You could not update request"
        ];
    }

    public function getData($params, $user)
    {
        $oldRequest = clone $user;
        $user->update($params);
        $data = [
            'request_id' => $oldRequest['id'],
            'category_id_before' => $oldRequest['category_id'],
            'category_id_current' => $user['category_id'],
            'content_before' => $oldRequest['content'],
            'content_current' => $user['content'],
            'due_date_before' => date("Y-m-d", strtotime($oldRequest['due_date'])),
            'due_date_current' => date("Y-m-d", strtotime($user['due_date'])),
            'admin_id_before' => $oldRequest['admin_id'],
            'admin_id_current' => $user['admin_id'],
            'status_admin_before' => $oldRequest['status_admin'],
            'status_admin_current' => $user['status_admin'],
            'status_manager_before' => $oldRequest['status_manager'],
            'status_manager_current' => $user['status_manager'],
            'priority_before' => $oldRequest['priority'],
            'priority_current' => $user['priority'],
            'title_before' => $oldRequest['title'],
            'title_current' => $user['title'],
            'user_id' => $oldRequest['user_id']
        ];
        return $data;
    }

    public function isDepartment($user)
    {
        if (Auth::user()->department_id == $user->department_id) {
            return true;
        }
        return false;
    }

    public function isUserOfRequest($user)
    {
        if (Auth::user()->id == $user->user_id) {
            return true;
        }
        return false;
    }

    public function isOpenRequestStatus($user)
    {
        $adminStatus = $user->status_admin;
        $managerStatus = $user->status_manager;
        if ($adminStatus === Config::get('statuses.request_status.open')
            && $managerStatus === Config::get('statuses.request_status.open')) {
            return true;
        }
        return false;
    }

    public function sendMail($data, $view, $subject, $author, $assign)
    {
        dispatch(new SendEmail($data, $view, $subject, $author, $assign));
    }

    public function getContentToSendMail($request)
    {
        $data = [
            'id' => $request->id,
            'title' => $request->title,
            'content' => $request->content,
            'status_admin' => $request->status_admin,
            'status_manager' => $request->status_manager,
            'created' => $request->created_at->format('Y-m-d'),
            'category_id' => $request->category->id,
            'category' => $request->category->name,
            'assign' => $request->admin->name,
            'assign_id'=>$request->admin->id,
            'author' => $request->user->name,
            'due_date' => $request->due_date,
            'priority'=>$request->priority,
            'email_author' => $request->user->email,
            'email_assign' => $request->admin->email
        ];
        return $data;
    }

    public function getInforDifferencesRequestAfterChange($data)
    {
        $dataChange=[];
        if ($data->content_before != $data->content_current) {
            $newData['content']['old'] = $data->content_before;
            $newData['content']['new'] = $data->content_current;
        }
        if ($data->due_date_before != $data->due_date_current) {
            $newData['due_date']['old'] = $data->due_date_before;
            $newData['due_date']['new'] = $data->due_date_current;
        }
        if ($data->admin_id_before != $data->admin_id_current) {
            $newData['admin_id']['old'] = $data->adminBefore->name;
            $newData['admin_id']['new'] = $data->adminCurrent->name;
        }
        if ($data->status_admin_before != $data->status_admin_current) {
            $newData['status_admin']['old'] = $data->status_admin_before;
            $newData['status_admin']['new'] = $data->status_admin_current;
        }
        if ($data->status_manager_before != $data->status_manager_current) {
            $newData['status_manager']['old'] = $data->status_manager_before;
            $newData['status_manager']['new'] = $data->status_manager_current;
        }
        if ($data->priority_before != $data->priority_current) {
            $newData['priority']['old'] = $data->priority_before;
            $newData['priority']['new'] = $data->priority_current;
        }
        if ($data->title_before != $data->title_current) {
            $newData['title']['old'] = $data->title_before;
            $newData['title']['new'] = $data->title_current;
        }
        if ($data->category_id_before != $data->category_id_current) {
            $newData['category']['old'] = $data->categoryBefore->name;
            $newData['category']['new'] = $data->categoryCurrent->name;
        }
        if (!empty($newData)) {
            $dataChange=[
                'request_id' => $data->request_id,
                'title' => $data->title_before,
                'user_id' => $data->user_id,
                'updated_by' => Auth::user()->id,
                'content' => json_encode($newData)
            ];
        }
        return $dataChange;
    }

    public function insertHistory($data)
    {
        $historyRequestAfterUpdate = $this->getInforDifferencesRequestAfterChange($data);
        if (!empty($historyRequestAfterUpdate)) {
            return $this->historyRepository->store($historyRequestAfterUpdate);
        }
    }

    public function insertComment($data)
    {
        $commentForRequestChanged = $this->getInforDifferencesRequestAfterChange($data);
        if (!empty($commentForRequestChanged)) {
            return $this->commentRepository->store([
                'content' => $commentForRequestChanged['content'],
                'request_id' => $commentForRequestChanged['request_id'],
                'user_id' => auth()->user()->id,
                'type' => config('constant.type.updateRequest'),
            ]);
        }
    }

    public function sendMailUpdateRequest($data, $view, $author, $assignBefore, $updatedBy, $subject, $assignCurrent)
    {
        dispatch(
            new SendEmailUpdateRequest(
                $data,
                $view,
                $author,
                $assignBefore,
                $updatedBy,
                $subject,
                $assignCurrent
            )
        );
    }

    public function getDataAfterHandle($newData, $assignBefore)
    {
        $author = $newData->user->email;
        $updatedBy = $newData->userUpdate->email;
        $requestId = $newData->request_id;
        $request = $this->requestRepository->find($requestId);
        $assignCurrent = $request->admin->email;
        $view = "update_request";
        $subject = "Update Request";
        $sendMailValue = json_decode($newData->content, true);
        $this->sendMailUpdateRequest(
            $sendMailValue,
            $view,
            $author,
            $assignBefore,
            $updatedBy,
            $subject,
            $assignCurrent
        );
    }

    public function getCategoryForAssign($id)
    {
        return $this->categoryRepository->getListCategoryForAssign($id, ['id', 'name', 'status'])->get();
    }
}
