<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Shop\Entity\User;

class UserAuthController extends Controller
{
    public function facebookSignInProcess()
    {
        $redirect_url = env('FB_REDIRECT');

        return Socialite::driver('facebook')
            ->scopes(['user_friends'])
            ->redirectUrl($redirect_url)
            ->redirect();
    }


}
