<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;
use App\Http\Requests\Api\Login\LoginRequest;
use App\Http\Requests\Api\Login\ForgotRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\Login\ResetRequest;
use Illuminate\Support\Facades\Config;
use App\Jobs\SendEmailToken;
use App\Http\Requests\Api\Login\ChangePassword;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }
        $user = $request->user();
        if ($user->status == Config::get('statuses.user_status.0')) {
            return response()->json([
                'message' => 'Your account is inactive'
            ], 401);
        }
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
            'name' => Auth::user()->name,
            'role' => Auth::user()->role_id,
            'department' => Auth::user()->department_id,
            'id' => Auth::user()->id
        ]);
    }
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        return response()->json([
            'message' => 'You have successfully logout'
        ]);
    }

    public function forgot(ForgotRequest $request)
    {
        $email = $request->email;
        if (User::where('email', $email)->doesntExist()) {
            return response()->json([
                'message' => 'This email doesnt exist in system !'
            ], 404);
        }
        $token = Str::uuid();
        if ($this->isEmailHasTokenBefore($email)) {
            return $this->updateToken($email, $token);
        }
        return $this->insertToken($email, $token);
    }

    public function reset(ResetRequest $request)
    {
        $token = $request->token;
        if (!$passwordReset = DB::table('password_resets')->where('token', $token)->first()) {
            return response()->json([
                'message' => 'Invalid token in system!'
            ], 404);
        }
        if (!$this->isTokenExpired($token)) {
            return response()->json([
                'message' => 'Invalid token time in system !'
            ], 404);
        }
        if (!$user = User::where('email', $passwordReset->email)->first()) {
            return response()->json([
                'message' => 'User doesnt exist in system !'
            ], 404);
        }
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'message' => 'Reset password success'
        ]);
    }

    public function isTokenExpired($token)
    {
        $timeToken = DB::table('password_resets')->where('token', $token)->first();
        if (Carbon::parse($timeToken->expires_at) > Carbon::now()) {
            return true;
        }
        return false;
    }

    public function isEmailHasTokenBefore($email)
    {
        if (DB::table('password_resets')->where('email', $email)->first()) {
            return true;
        }
        return false;
    }
    
    public function insertToken($email, $token)
    {
        try {
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $token,
                'expires_at' => Carbon::now()->addDays(1)
            ]);
            return $this->sendMail($email, $token);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function updateToken($email, $token)
    {
        try {
            DB::table('password_resets')->where('email', $email)->update([
                'token' => $token,
                'expires_at' => Carbon::now()->addDays(1)
            ]);
            return $this->sendMail($email, $token);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage()
            ]);
        }
    }

    public function sendMail($email, $token)
    {
        dispatch(new SendEmailToken($email, $token));
        return response()->json([
            'message' => 'Please check your email !'
        ]);
    }

    public function changePassword(ChangePassword $request)
    {
        $user = Auth::user();
        $oldPassword = $request->oldPassword;
        $newPassword = $request->newPassword;
        if (User::where('email', $user->email) && Hash::check($oldPassword, $user->password)) {
            User::where('email', $user->email)->update(['password' => Hash::make($newPassword)]);
            return response()->json([
               'message' => 'Change password is successful'
            ]);
        }
        return response()->json([
            'message' => "Old Password is not correct"
        ], 401);
    }
}
