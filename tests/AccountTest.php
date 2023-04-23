<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AccountTest extends TestCase
{
    /**
     * Tests the accounts endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testAccountsEndpointFailure()
    {
        $response = $this->get('api/v1/accounts/');

        $response->assertResponseStatus(401);
    }
}
