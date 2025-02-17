<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthController extends Controller
{
    // Display the login form
    public function showLoginForm()
    {
        if (session('api_token')) {
            return redirect()->route('authors.index');
        }
    
        return view('auth.login');
    }

    // Process the login form submission
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);

        $client = new Client();

        try {
            $response = $client->post(config('app.api_base_url') . 'token', [
                'json' => $credentials
            ]);

            $data = json_decode($response->getBody(), true);

            session([
                'api_token'  => $data['token_key'],
                'refresh_token_key' => $data['refresh_token_key'],
                'id'         => $data['user']['id'],
                'email'      => $data['user']['email'],
                'first_name' => $data['user']['first_name'] ?? '',
                'last_name'  => $data['user']['last_name'] ?? '',
            ]);

            // Store token in Laravel cache
            Cache::put('api_token', $data['token_key'], now()->addHours(12)); // Store for 12 hours

            return redirect()->route('authors.index');
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Login failed. Please check your credentials and try again.'
            ]);
        }   
    }

    public function destroy()
    {
        session()->flush(); // Clear all session data
        Cache::forget('api_token'); // Clear stored API token
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}

