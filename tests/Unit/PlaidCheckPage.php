<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlaidCheckPage extends TestCase
{
    /**
     * test to access plaid page
     *
     * @return void
     */
    public function testAccessToPlaidPage()
    {
        $response = $this->get('/test');

        $response->assertStatus(200);
    }
}
