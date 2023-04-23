<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $logoutEndpoint = 'api/v1/users/logout/';               // API Logout Endpoint

    /**
     * Tests that incorrect user credentials will result in an unsuccessful login attempt.
     *
     * @return void
     */
    public function testUserLoginEndpointFailure()
    {
        $response = $this->post($this->loginEndpoint, [
            'email' => 'badusername',
            'password' => 'badpassword'
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests that correct user credentials will successfully login a user.
     *
     * @return void
     */
    public function testUserLoginEndpoint()
    {
        $response = $this->post($this->loginEndpoint, [
            'email' => 'jdoe@test.com',
            'password' => 'apassword'
        ]);

        $response->assertResponseStatus(200);
    }

    /**
     * Tests if there is a request sent to the logout endpoint without a user being logged in that the
     * response status is a 401 error.
     * 
     * @return void
     */
    public function testUserLogoutEndpointFailure()
    {
        $response = $this->post($this->logoutEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the user logout endpoint by first successfully logging in a user, then sending a POST request
     * to the logout endpoint which should result in a response status of 200.
     * 
     * @return void
     */
    public function testUserLogoutEndpoint()
    {
        $loginResponse = $this->post($this->loginEndpoint, [
            'email' => 'jdoe@test.com',
            'password' => 'apassword'
        ]);

        // Assert successful login
        $loginResponse->assertResponseStatus(200);

        $logoutResponse = $this->post($this->logoutEndpoint);

        // Assert successful logout
        $logoutResponse->assertResponseStatus(200);
    }
}