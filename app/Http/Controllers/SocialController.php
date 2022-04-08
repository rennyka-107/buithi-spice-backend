<?php

namespace App\Http\Controllers;

use App\Http\Resources\User\UserResource;
use App\Models\SocialAccount;
use App\Models\User;
use App\Services\SocialService\SocialServiceInterface as SocialService;
use DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public $social_service;
    public function __construct(SocialService $social_service)
    {
        $this->social_service = $social_service;
    }
    public function socialLoginUrl($provider)
    {
        return Response::json([
            'url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl(),
        ]);
    }

    public function loginSocialCallback($provider)
    {
        $googleUser = Socialite::driver($provider)->stateless()->user();
        $user = null;
        DB::transaction(function () use ($googleUser, &$user, $provider) {
            $socialAccount = SocialAccount::firstOrNew(
                ['social_id' => $googleUser->getId(), 'provider' => $provider],
            );
            if (!($user = $socialAccount->user)) {
                $user = User::where('email', $googleUser->getEmail())->first();
                if (!$user) {
                    $user = User::create([
                        'email' => $googleUser->getEmail(),
                        'name' => $googleUser->getName(),
                        'password' => Hash::make('rennyka-blogs-107'),
                        'avatar' => $googleUser->getAvatar()
                    ]);
                }
                $socialAccount->fill(['user_id' => $user->id])->save();
            }
        });

        if ($user) {
            return Response::json([
                'status' => true,
                'user' => new UserResource($user),
                'google_user' => $googleUser,
                'access_token' => $user->createToken('Tachyon 107 access token')->plainTextToken
            ]);
        }
        return Response::json([
            'status' => false
        ]);
    }
}
