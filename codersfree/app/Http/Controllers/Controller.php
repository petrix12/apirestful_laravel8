<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // Verifica si el token esta caducado para solicitar otro
    public function resolveAuthorization(){
        if(auth()->user()->accessToken->expires_at <= now()){
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://api.codersfree.test/oauth/token', [
                'grant_type' => 'refresh_token',
                'refresh_token' => auth()->user()->accessToken->refresh_token,
                'client_id' => config('services.codersfree.client_id'),
                'client_secret' => config('services.codersfree.client_secret')
            ]);
    
            $access_token = $response->json();
    
            auth()->user()->accessToken->update([
                'access_token' => $access_token['access_token'],
                'refresh_token' => $access_token['refresh_token'],
                'expires_at' => now()->addSecond($access_token['expires_in'])
            ]);           
        }
    }
}
