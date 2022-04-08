<?php

namespace App\Services\UserService;

use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;
use App\Repositories\UserRepository\UserRepositoryInterface as UserRepository;
use App\Services\BaseService;
use Auth;
use Illuminate\Support\Facades\Hash;

class UserService extends BaseService implements UserServiceInterface
{
    protected $user_repository;
    public function __construct(UserRepository $user_repository)
    {
        $this->user_repository = $user_repository;
    }
    public function get($id)
    {
        $user = $this->user_repository->get($id);
        return $user ? new UserResource($user) : null;
    }
    public function getAll($option)
    {
        return new UserCollection($this->user_repository->getAll($option));
    }
    public function create($data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = $this->user_repository->create($data);
        return $user ? new UserResource($user) : null;
    }
    public function update($data)
    {
        $user = $this->user_repository->update($data);
        return $user ? new UserResource($user) : null;
    }
    public function delete($id)
    {
        return $this->user_repository->delete($id);
    }

    public function changePassword($data)
    {
        if (Auth::user()) {
            $current_password = Auth::user()->password;
            if (Hash::check($data['password'], $current_password)) {
                $data['password'] = bcrypt($data['new_password']);
                return $this->user_repository->changePassword($data);
            }
        }
        return null;
    }

    public function getAuthVerifyCode($email, $is_register = false)
    {
        $ran = random_int(1000, 9999);
        $code = Hash::make($email . $ran);
        $saved_code = $this->user_repository->saveVerifyCode($code, $email, $is_register);
        if ($saved_code) {
            return $is_register ? $ran : ['code_number' => $ran, 'user_id' => $saved_code->user_id];
        }
        return null;
    }
    public function renewForgotPassword($data)
    {
        return $this->user_repository->renewForgotPassword($data);
    }
}
