<?php

/**
 * This file tests the Users API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

class UserTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $logoutEndpoint = 'api/v1/users/logout/';               // API Logout Endpoint

    /**
     * Login function to log the test user into the API.
     * 
     * @param $loginEndpoint
     * @param $email
     * @param $password
     * @return void
     */
    private function login($loginEndpoint, $email, $password)
    {
        $response = $this->post($loginEndpoint, [
            'email' => env($email),
            'password' => env($password)
        ]);

        $response->assertResponseStatus(200);
    }

    /**
     * Tests that incorrect user credentials will result in an unsuccessful login attempt.
     *
     * @return void
     */
    public function testUserLoginEndpointFailure()
    {
        // Attempt to login an invalid user
        $response = $this->post($this->loginEndpoint, [
            'email' => 'badusername',
            'password' => 'badpassword'
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests that a user is not able to log in without providing a valid password, in addition to a valid
     * username.
     * 
     * @return void
     */
    public function testUserLoginEndpointFailureNoPassword()
    {
        // Attempt to login an invalid user
        $response = $this->post($this->loginEndpoint, [
            'email' => env($this->email)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests that a user is not able to log in without providing a valid username, in addition to a valid
     * password.
     * 
     * @return void
     */
    public function testUserLoginEndpointFailureNoUsername()
    {
        // Attempt to login an invalid user
        $response = $this->post($this->loginEndpoint, [
            'password' => env($this->password)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests that correct user credentials will successfully login a user.
     *
     * @return void
     */
    public function testUserLoginEndpoint()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);
    }

    /**
     * Tests if there is a request sent to the logout endpoint without a user being logged in that the
     * response status is a 401 error.
     * 
     * @return void
     */
    public function testUserLogoutEndpointFailure()
    {
        // Attempt to logout a user that hasn't logged in
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
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Logout the test user
        $logoutResponse = $this->post($this->logoutEndpoint);

        $logoutResponse->assertResponseStatus(200);
    }
}