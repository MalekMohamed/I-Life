<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Socialite;
use App\Services\SocialService;
class SocialAuthProviderController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function handleProviderCallback(SocialService $service,$provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (Exception $e) {
            return redirect('/login');
        }

        $authUser = $service->createOrGetUser($user, $provider);
        auth()->login($authUser);
        return redirect()->to('/shop');
    }
}