<?php

namespace App\Repositories\UserRepository;

use App\Models\CodeForgotPassword;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Services\Firebase\ImageService;
use Auth;
use DB;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function get($id)
    {
        try {
            return User::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return null;
        }
    }

    public function getAll($option)
    {
        return User::paginate($option['size']);
    }
    public function create($data)
    {
        $user = null;
        if ($data['avatar']) {
            unset($data['avatar']);
        }
        DB::transaction(function () use ($data, &$user) {
            $code = CodeForgotPassword::where('email', $data['email'])->first();
            if ($code && Hash::check($data['email'] . $data['code'], $code->code)) {
                $user = User::create($data->all());
                $code->delete();
            }
        });
        return $user;
    }
    public function update($data)
    {
        if ($data['id'] != Auth::id()) return null;
        try {
            $user = User::findOrFail($data['id']);
            if ($image = $data['avatar']) {
                unset($data['avatar']);
                ImageService::deleteImageFirebase($data['email'] . '-' . $data['name'] . '.' . $image->getClientOriginalExtension(), "Users/");
                $data['avatar'] = ImageService::uploadImageClientToFirebase($image, $data['email'] . '-' . $data['name'], "Users/");
            }

            $user->update($data->all());
            return $user;
        } catch (Exception $e) {
            return null;
        }
    }
    public function delete($id)
    {
        try {
            $user = User::findOrFail($id);
            if ($user['avatar']) {
                ImageService::deleteImageFirebase($user['avatar'], "Users/");
            }
            $user->delete();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public function changePassword($data)
    {
        $user = Auth::user();
        $user->update(['password' => $data['password']]);
        return $user;
    }

    public function saveVerifyCode($code, $email, $is_register = false)
    {
        $new_code = null;
        if ($is_register) {
            $new_code = CodeForgotPassword::create(['code' => $code, 'email' => $email]);
        } else {
            $user = User::where('email', $email)->first();
            if ($user) {
                $new_code = CodeForgotPassword::create(['code' => $code, 'user_id' => $user->id, 'email' => $email]);
            }
        }
        return $new_code ? $new_code : null;
    }

    public function renewForgotPassword($data)
    {
        $random_pass = null;
        $email = null;
        DB::transaction(function () use ($data, &$random_pass, &$email) {
            $code = CodeForgotPassword::where('user_id', $data['user_id'])->first();
            if ($code && Hash::check($code->user->email . $data['code'], $code->code)) {
                $user = User::where('id', $code->user_id)->first();
                if ($user) {
                    $random_pass = random_int(100000, 999999);
                    $email = $user->email;
                    $user->update(['password' => Hash::make($random_pass)]);
                    $code->delete();
                }
            }
        });
        if ($random_pass && $email) {
            return ['email' => $email, 'new_password' => $random_pass];
        }
        return null;
    }
}
