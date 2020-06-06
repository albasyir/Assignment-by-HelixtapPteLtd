<?php

namespace App\Helpers;

use TomorrowIdeas\Plaid\Plaid as BasePlaid;

class PlaidHelper
{
    /**
     * Start PlaidHelper easier to use
     *
     */
    public static function start()
    {
        // default config
        $client_id = env('PLAID_CLIENT_ID', '');
        $client_secret = env('PLAID_SECRET', '');
        $client_public_key = env('PLAID_PUBLIC_KEY', '');

        // create object
        $plaid = new BasePlaid(
            $client_id,
            $client_secret,
            $client_public_key
        );

        // set ENV
        $plaid->setEnvironment(env('PLAID_ENV', "sandbox"));

        // return object
        return $plaid;
    }
}
