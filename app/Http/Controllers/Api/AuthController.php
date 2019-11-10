<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post('http://laravel.local:85/ljtodolist-backend/public/oauth/token', [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => '2',
                    'client_secret' => 'y88Q1srb7LmcUNeNrj2azDFx3Tsepi9eIw8w7i1e',
                    'username' => $request->email,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            if ($e->getCode() === 400) {
                return response()->json('Invalid Request. Please enter a email or a password.', $e->getCode());
            } else if ($e->getCode() === 401) {
                return response()->json('Your credentials are incorrect. Please try again', $e->getCode());
            }
            return response()->json('Something went wrong on the server.', $e->getCode());
        }
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name'=>'required|string|max:55',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=>Hash::make( $request['password'])
        ]);

        return $user;

        //$accessToken = $user->createToken('authToken')->accessToken;

        //return response(['user' => $user, 'access_token' => $accessToken]);
    }
}
