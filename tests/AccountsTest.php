<?php

/**
 * This file tests the Accounts API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AccountsTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $tableName = 'accounts';                                // Name of the table we're working in
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $accountsEndpoint = 'api/v1/accounts/';                 // API Accounts Endpoint
    private $accountsPage = 'api/v1/accounts/page/';                // API Accounts Page Endpoint
    private $accountsQuicklook = 'api/v1/accounts/quicklook';       // API Accounts Quicklook

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
     * Post Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a POST request with a user being logged in and missing
     * fields, which should result in a response status of 422 and a no new account entry being created.
     * 
     * @return void
     */
    public function testAccountsEndpointPostMissingFieldFailure()
    {
        // Create Faker instance to generate account values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new account values request
        $response = $this->post($this->accountsEndpoint, [
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests the accounts endpoint by sending a POST request without a user being logged in, which should
     * result in a response status of 401 and no new account entry being created.
     * 
     * @return void
     */
    public function testAccountsEndpointPostNoLoginFailure()
    {
        // Create Faker instance to generate account values
        $faker = Faker::create();

        // Send new account values request
        $response = $this->post($this->accountsEndpoint, [
            'account_name' => $faker->name,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a POST request with a user being logged in, which should
     * result in a response status of 201 and a new account entry being created.
     * 
     * This test is a dependency for: testAccountsEndpointDelete()
     * 
     * @return void
     */
    public function testAccountsEndpointPost()
    {
        // Create Faker instance to generate account values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new account values request
        $response = $this->post($this->accountsEndpoint, [
            'account_name' => $faker->name,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(201);
    }

    /************************************************************
     * Put Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a PUT request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testAccountsEndpointPutBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new account values request
        $response = $this->put($this->accountsEndpoint . $id, [
            'account_name' => 'test',
            'user_id' => 1
        ]);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the accounts endpoint by sending a PUT request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testAccountsEndpointPutNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Send new account values request
        $response = $this->put($this->accountsEndpoint . $id, [
            'account_name' => 'test',
            'user_id' => 1
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a PUT request with a user being logged in, which should
     * result in a response status of 200 and an account entry being updated.
     * 
     * @return void
     */
    public function testAccountsEndpointPut()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new account values request
        $response = $this->put($this->accountsEndpoint . $id, [
            'account_name' => 'test',
            'user_id' => 1
        ]);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testAccountsEndpointGetFailure()
    {
        // Get all accounts
        $response = $this->get($this->accountsEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testAccountsGetEndpoint()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get all accounts
        $response = $this->get($this->accountsEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Id Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a GET request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testAccountsEndpointGetByIdBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get account by id
        $response = $this->get($this->accountsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the accounts endpoint by sending a GET request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testAccountsEndpointGetByIdNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Get account by id
        $response = $this->get($this->accountsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a GET request with a user being logged in and a valid entry
     * id, which should result in a response status of 200.
     *
     * @return void
     */
    public function testAccountsEndpointGetById()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get account by id
        $response = $this->get($this->accountsEndpoint . $id);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Page Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a GET request with a user being logged in and a empty page
     * value, which should result in a response status of 405.
     *
     * @return void
     */
    public function testAccountsEndpointGetByPageBadPageFailure()
    {
        // Empty page to query
        $page = '';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get accounts by page
        $response = $this->get($this->accountsPage . $page);

        $response->assertResponseStatus(405);
    }

    /**
     * Tests the accounts endpoint by sending a GET request without a user being logged in and a valid page
     * value, which should result in a response status of 401.
     *
     * @return void
     */
    public function testAccountsEndpointGetByPageNoLoginFailure()
    {
        // Empty page to query
        $page = '1';

        // Get accounts by page
        $response = $this->get($this->accountsPage . $page);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a GET request with a user being logged in and a valid page
     * value, which should result in a response status of 200.
     *
     * @return void
     */
    public function testAccountsEndpointGetByPage()
    {
        // Empty page to query
        $page = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get accounts by page
        $response = $this->get($this->accountsPage . $page);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Quicklook Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts quicklook endpoint by sending a GET request without a user being logged in, 
     * which should result in a response status of 401 and no account entries being returned.
     * 
     * @return void
     */
    public function testAccountsEndpointQuicklookFailure()
    {
        // Get quicklook accounts
        $response = $this->get($this->accountsQuicklook);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts quicklook endpoint by sending a GET request with a user being logged in, 
     * which should result in a response status of 200 and 10 account entries being returned.
     * 
     * @return void
     */
    public function testAccountsEndpointQuicklook()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get quicklook accounts
        $response = $this->get($this->accountsQuicklook);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Delete Route
     *
     *
     ************************************************************/

    /**
     * Tests the accounts endpoint by sending a DELETE request with a user being logged in and with an
     * invalid entry id, which should result in a response status of 404 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testAccountsEndpointDeleteBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->accountsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the accounts endpoint by sending a DELETE request without a user being logged in and with an
     * valid entry id, which should result in a response status of 401 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testAccountsEndpointDeleteNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->accountsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the accounts endpoint by sending a DELETE request with a user being logged in, which should
     * result in a response status of 200 and the latest entry being deleted.
     * 
     * @depends testAccountsEndpointPost
     * @return void
     */
    public function testAccountsEndpointDelete()
    {
        // Retrieve the id of the latest entry ()
        $latestId = DB::table($this->tableName)->latest('id')->value('id');

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->accountsEndpoint . $latestId);

        $response->assertResponseStatus(200);
    }
}
