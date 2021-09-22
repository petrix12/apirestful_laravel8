<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class OauthController extends Controller
{
    public function redirect(Request $request){
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => config('services.codersfree.client_id'),
            'redirect_uri' => route('callback'),
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
        ]);
    
        return redirect('http://api.codersfree.test/oauth/authorize?'.$query);        
    }

    public function callback(Request $request){
        return $request->all();
    }
}
