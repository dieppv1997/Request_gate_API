<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Mail;
use App\Jobs\SendEmailCreatAccount;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginGoogle(Request $request)
    {
        $accessToken = $request->access_token;
        $getContentForAccessToken = file_get_contents('https://www.googleapis.com/oauth2/v3/userinfo?access_token='
            . $accessToken);
        $userDetails = json_decode($getContentForAccessToken, true);
        $user = User::where('email', $userDetails['email'])->first();
        if (!$user) {
            return [
                'message' => 'User not found !',
                'data' => [
                    'name' => $userDetails['name'],
                    'email' => $userDetails['email'],
                    'employee_id' => Str::before($userDetails['email'], '@hblab.vn'),
                ],
            ];
        }
        if ($user['status'] === config('statuses.user_status.0')) {
            return [
                'message' => 'User is inactive!',
            ];
        }
        return $this->createToken($request, $user);
    }

    public function createToken($request, $user)
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'name' => $user->name,
            'role' => $user->role_id,
            'department' => $user->department_id,
            'id' => $user->id,
        ]);
    }

    public function signUpByGoogleUser(Request $request)
    {
        $password = Str::random(10);
        $email = $request->email;
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => config('role.user'),
            'department_id' => $request->department_id,
            'status' => config('statuses.user_status.1'),
            'employee_id' => $request->employee_id,
            'password' => Hash::make($password),
        ]);
        $this->sendMail($email, $password);
        return $this->createToken($request, $user);
    }

    public function sendMail($email, $password)
    {
        dispatch(new SendEmailCreatAccount($email, $password));
    }
}
