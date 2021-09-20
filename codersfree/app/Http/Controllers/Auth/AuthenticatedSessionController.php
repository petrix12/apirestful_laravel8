<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json'
        ])->post('http://api.codersfree.test/v1/login', [
            'email' => $request->email,
            'password' => $request->password
        ]);

        if ($response->status() == 404) {
            return back()->withErrors('These credentials do not match our records.');
        }

        $service = $response->json();

        $user = User::updateOrcreate([
            'email' => $request->email
        ], $service['data']);

        if (!$user->accessToken) {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])->post('http://api.codersfree.test/oauth/token', [
                'grant_type' => 'password',
                'client_id' => '94717435-7f73-4d1a-a9e2-0b88b0401377',
                'client_secret' => '5yo9JZN2W8kA9JVkvQE8KymeI48uBfm3F7ipLGXr',
                'username' => $request->email,
                'password' => $request->password
            ]);

            $access_token = $response->json();

            $user->accessToken()->create([
                'service_id' => $service['data']['id'],
                'access_token' => $access_token['access_token'],
                'refresh_token' => $access_token['refresh_token'],
                'expires_at' => now()->addSecond($access_token['expires_in'])
            ]);
        }

        Auth::login($user, $request->remember);
        return redirect()->intended(RouteServiceProvider::HOME);

        /*if (!$user->accessToken) {

            $this->setAccessToken($user, $service);
            
        }
        
        Auth::login($user, $request->remember);

        return redirect()->intended(RouteServiceProvider::HOME); */
    
        /* $request->authenticate();
        $request->session()->regenerate();
        return redirect()->intended(RouteServiceProvider::HOME); */
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
