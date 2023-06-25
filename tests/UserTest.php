<?php

/**
 * This file tests the Users API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;

class UserTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $usersEndpoint = 'api/v1/users/';                       // API User Endpoint
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $logoutEndpoint = 'api/v1/users/logout/';               // API Logout Endpoint
    private $registerEndpoint = 'api/v1/users/register/';           // API Register Endpoint
    private $refreshEndpoint = 'api/v1/users/refresh/';             // API Refresh Endpoint

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

    /************************************************************
     * User/Register Route
     *
     *
     ************************************************************/

    /**
     * Tests the user register endpoint by sending a POST request to attempt to register a new user. This
     * should fail, as it's missing a required field, and return a status of 422.
     * 
     * Missing the 'full_name' field
     * 
     * @return void
     */
    public function testUserRegisterEndpointMissingFieldFailure()
    {
        // Create Faker instance to generate user values
        $faker = Faker::create();

        // Send new user values request
        $response = $this->post($this->registerEndpoint, [
            'first_name' => $faker->firstName('female'),
            'last_name' => $faker->lastName,
            'email' => $faker->unique()->safeEmail,
            'password' => $faker->password
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests the user register endpoint by sending a POST request to attempt to register a new user. This
     * should succeed, create a new user entry, and return a status of 201.
     * 
     * @return void
     */
    public function testUserRegisterEndpoint()
    {
        // Create Faker instance to generate user values
        $faker = Faker::create();

        // Prepare user name for full name field
        $firstName = $faker->firstName('female');
        $lastName = $faker->lastName;
        $fullName = $firstName . " " . $lastName;

        // Send new user values request
        $response = $this->post($this->registerEndpoint, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'email' => $faker->unique()->safeEmail,
            'password' => $faker->password
        ]);

        $response->assertResponseStatus(201);
    }

    /************************************************************
     * User/Login Route
     *
     *
     ************************************************************/

    /**
     * Tests that incorrect user credentials will result in an unsuccessful login attempt.
     *
     * @return void
     */
    public function testUserLoginEndpointBadCredentialsFailure()
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
    public function testUserLoginEndpointNoPasswordFailure()
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
    public function testUserLoginEndpointNoUsernameFailure()
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

    /************************************************************
     * User/Logout Route
     *
     *
     ************************************************************/

    /**
     * Tests if there is a request sent to the logout endpoint without a user being logged in that the
     * response status is a 401 error.
     * 
     * @return void
     */
    public function testUserLogoutEndpointNoLoginFailure()
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
        $response = $this->post($this->logoutEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * User/Refresh Route
     *
     *
     ************************************************************/

    /**
     * Tests that a user is unable to refresh their access token through a POST request if they're not
     * logged in. This should respond with a status of 401.
     * 
     * @return void
     */
    public function testUserRefreshEndpointPostNoLoginFailure()
    {
        // Refresh access token
        $response = $this->post($this->refreshEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests that a user is able to refresh their access token through a POST request. This should respond
     * with a status of 200.
     * 
     * @return void
     */
    public function testUserRefreshEndpointPost()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Refresh access token
        $response = $this->post($this->refreshEndpoint);

        $response->assertResponseStatus(200);
    }

    /**
     * Tests that a user is unable to refresh their access token through a GET request if they're not
     * logged in. This should respond with a status of 401.
     * 
     * @return void
     */
    public function testUserRefreshEndpointGetNoLoginFailure()
    {
        // Refresh access token
        $response = $this->get($this->refreshEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests that a user is able to refresh their access token through a GET request. This should respond
     * with a status of 200.
     * 
     * @return void
     */
    public function testUserRefreshEndpointGet()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Refresh access token
        $response = $this->post($this->refreshEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Put Route
     *
     *
     ************************************************************/

    /**
     * Tests the users endpoint by sending a PUT request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testUsersEndpointPutBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new user values request
        $response = $this->put($this->usersEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test_user',
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the users endpoint by sending a PUT request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testUsersEndpointPutNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Send new user values request
        $response = $this->put($this->usersEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test_user',
            'email' => 'test@test1.com',
            'password' => 'password'
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the users endpoint by sending a PUT request with a user being logged in, which should
     * result in a response status of 200 and an user entry being updated.
     * 
     * @return void
     */
    public function testUsersEndpointPut()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new user values request
        $response = $this->put($this->usersEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test_user',
            'email' => 'test@test.com',
            'password' => 'password'
        ]);

        $response->assertResponseStatus(200);
    }
}