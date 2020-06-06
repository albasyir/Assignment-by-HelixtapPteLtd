<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use TomorrowIdeas\Plaid\Plaid;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('schedule:start', function () {
    exec("schedule:run >> /dev/null 2>&1");
});

// Artisan::command('notif', function () {
//     event(new App\Events\ExampleEvent(['berhasil' => true]));
// });
