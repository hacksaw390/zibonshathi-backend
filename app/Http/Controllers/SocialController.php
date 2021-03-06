<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Redirect, Response, File;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class SocialController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {

        $getInfo = Socialite::driver($provider)->user();

        $update = User::where('email', '=', $getInfo->email)->first();
        if ($update) {
            $emailProviderId = $update->provider_id;
            if($emailProviderId != $getInfo->id){
                return view('frontend.pages.signin_up_regis_prob', compact('update'));
            }
            else{
                $user = $this->createUser($getInfo, $provider);
                auth()->login($user);
                return redirect()->to('/');
            }
        } else {
            $user = $this->createUser($getInfo, $provider);
            auth()->login($user);
            return redirect()->to('/');
        }
    }
    function createUser($getInfo, $provider)
    {

        $user = User::where('provider_id', $getInfo->id)->first();

        if (!$user) {
            $user = User::create([
                'name'     => $getInfo->name,
                'email'    => $getInfo->email,
                'provider' => $provider,
                'provider_id' => $getInfo->id
            ]);
        }
        return $user;
    }
}
