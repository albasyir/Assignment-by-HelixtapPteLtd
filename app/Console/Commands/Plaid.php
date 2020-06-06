<?php

namespace App\Console\Commands;

use App\Events\ExampleEvent;
use App\Helpers\PlaidHelper;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use TomorrowIdeas\Plaid\Plaid as PlaidClient;

class Plaid extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plaid:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Try to check update, if founded we return the response from plaid app to client';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get all session
        $all_session = DB::table('sessions')->get();

        // pripare Plaid Clinet
        $plaid = PlaidHelper::start();

        // loop each session data
        $all_session->each(function ($session) use ($plaid) {
            $session_data = unserialize(base64_decode($session->payload));

            // check user have access token  && have channel
            if (
                !isset($session_data['plaid']['access_token'])
                ||
                !isset($session_data['plaid']['channels_key'])
            ) {
                $this->info("Skipping sesison {$session->id}");
                return;
            }

            $access_token = $session_data['plaid']['access_token'];
            $channel_token = $session_data['plaid']['channels_key'];

            // Try proccess
            try {
                // create public token API
                $exampleUpdate = $plaid->createPublicToken($access_token);

                // check if public token same like before
                // ( if have many data we use md5 )
                // md5($exampleUpdate) == md5($session_data['plaid']['public_token'])
                if (
                    isset($session_data['plaid']['public_token'])
                    &&
                    $session_data['plaid']['public_token'] == $exampleUpdate
                ) {
                    return;
                }

                // save to session data
                $session_data['plaid']['public_token'] = $exampleUpdate;

                // give event notif
                event(new ExampleEvent($channel_token, $exampleUpdate));

                // update for logging
                $this->info("Channel {$channel_token} geting update");
            } catch (\Exception $e) {
                // error logging
                $this->error("Channel {$channel_token} get error {$e->getMessage()} ({$e->getCode()})");
            }

            // rebuild payload of session
            $newSessionPayload = base64_encode(serialize($session_data));

            // store new payload to database
            DB::table('sessions')
                ->where("id", '=', $session->id)
                ->update([
                    'payload' => $newSessionPayload
                ]);
        });
    }
}
