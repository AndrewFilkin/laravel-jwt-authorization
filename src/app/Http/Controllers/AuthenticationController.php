<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthenticationController extends Controller
{
    public function login()
    {
        $email = 'andrew@gmail.com';
        $password = 'password';

        $url = env('AUTH_APP_URL');

        $responce = Http::post($url . '/api/login', [
            'email' => $email,
            'password' => $password,
        ]);

        if ($responce->failed()) {
            return ['error' => $responce->status()];
        }

        $data = json_decode($responce->body());

        $token_part = explode('.', $data->access_token);

        $header = base64_decode($token_part[0]);
        $payload = base64_decode($token_part[1]);

        // get user
//        $user = Http::withToken($data->access_token)->post($url . '/api/me');
//        return $user->body();

        return [$header, $payload];

    }
}
