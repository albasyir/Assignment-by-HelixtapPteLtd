<?php

namespace App\Http\Controllers;

use App\Helpers\PlaidHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PlaidController extends Controller
{
    /**
     * Show Page
     *
     */
    public function index()
    {
        return view('app');
    }

    /**
     * Get Screet token from Plaid Server
     *
     * @param Request $request
     *
     * @return JSON
     */
    public function getSecretToken(Request $request)
    {
        // Start Plaid
        $plaid = PlaidHelper::start();

        // Exchange token from public token to screet token
        $request_access = $plaid->exchangeToken($request->public_token);

        // Example Token Channel
        $notif_token = md5(rand(10000, 99999));

        // Put data to user session
        $request->session()->put('plaid', [
            'access_token' => $request_access->access_token,
            'channels_key' => $notif_token
        ]);

        // return response
        return response()->json([
            'owned_request_access' => true,
            'channels_key' => $notif_token
        ]);
    }
}
