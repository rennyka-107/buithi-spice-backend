<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Http\Requests\Auth\GetAllUserRequest;
use App\Http\Requests\Auth\GetVerifyCodeRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdateRequest;
use App\Http\Resources\User\UserResource;
use App\Jobs\SendEmail;
use App\Services\UserService\UserServiceInterface as UserService;
use Auth;
use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $user_service;
    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
    }

    public function register(RegisterRequest $request)
    {
        try {
            return response()->json(['status' => true, 'user' => $this->user_service->create($request)]);
        } catch (Exception $error) {
            return response()->json(['status' => false, 'error' => $error->getMessage()]);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'error' => 'Authorization failed!']);
        }
        return response()->json(['status' => true, 'user' => new UserResource($request->user()), 'access_token' => $request->user()->createToken('Tachyon 107 access token')->plainTextToken]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->currentAccessToken()->delete();
            return response()->json(['status' => true, 'message' => 'Logout from this device successfully!']);
        }
        return response()->json(['status' => false]);
    }

    public function logoutAllDevices(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->tokens()->delete();
            return response()->json(['status' => true, 'message' => 'Logout all devices successfully!']);
        }

        return response()->json(['status' => false]);
    }

    public function getAll(GetAllUserRequest $request)
    {
        try {
            $users = $this->user_service->getAll($request->all());
            return response()->json(["status" => count($users) > 0, "users" => $users]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function get($id)
    {
        try {
            $user = $this->user_service->get($id);
            return response()->json(["status" => $user !== null, "user" => $user]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function update(UpdateRequest $request, $id)
    {
        try {
            $request['id'] = $id;
            $user = $this->user_service->update($request);
            return response()->json(["status" => $user !== null, "user" => $user]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            return response()->json(["status" => $this->user_service->delete($id)]);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $new_user =  $this->user_service->changePassword($request->all());
            if ($new_user) {
                $new_user->tokens()->delete();
                return response()->json(["status" => true, 'user' => new UserResource($new_user), 'access_token' => $new_user->createToken('Tachyon 107 access token')->plainTextToken]);
            }
            return response()->json(['status' => false, 'error' => 'Password seem like not correct! Please try again!']);
        } catch (Exception $error) {
            return response()->json(['error' => $error->getMessage()]);
        }
    }

    public function getAuthVerifyCode(GetVerifyCodeRequest $request)
    {
        try {
            if ($request['flag_register']) {
                $code = $this->user_service->getAuthVerifyCode($request->email, true);
                if ($code) {
                    SendEmail::dispatch($request->email, $code, null)->delay(now()->addMinute(1));
                    return response()->json(['status' => true, 'message' => 'A mail sent your email address. Please use your verify code in that mail']);
                }
            } else {
                $code = $this->user_service->getAuthVerifyCode($request->email);
                if ($code) {
                    SendEmail::dispatch($request->email, $code['code_number'], null)->delay(now()->addMinute(1));
                    return response()->json(['status' => true, 'user_id' => $code['user_id'], 'message' => 'A mail sent your email address. Please use your verify code in that mail']);
                }
            }
            return response()->json(['status' => false, 'message' => 'Failed! Please try again!']);
        } catch (Exception $error) {
            return response()->json(['status' => false, 'error' => $error->getMessage()]);
        }
    }

    public function renewForgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $res =  $this->user_service->renewForgotPassword($request->all());
            if ($res) {
                SendEmail::dispatch($res['email'], null, $res['new_password'])->delay(now()->addMinute(1));
                return response()->json(['status' => true, 'message' => 'Your password reset successfully and sent to your email address! Please use it to login and dont forget change your new password!']);
            }
            return response()->json(['status' => false, 'message' => 'Failed! Please try again!']);
        } catch (Exception $error) {
            return response()->json(['status' => false, 'error' => $error->getMessage()]);
        }
    }
}
