<?php

/**
 * This file tests the Leads API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class LeadsTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $tableName = 'leads';                                   // Name of the table we're working in
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $leadsEndpoint = 'api/v1/leads/';                       // API Leads Endpoint
    private $leadsPage = 'api/v1/leads/page/';                      // API Leads Page Endpoint
    private $leadsQuicklook = 'api/v1/leads/quicklook/';            // API Leads Quicklook

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
     * Tests the leads endpoint by sending a POST request with a user being logged in and missing
     * fields, which should result in a response status of 422 and a no new lead entry being created.
     * 
     * Missing 'full_name' field
     * 
     * @return void
     */
    public function testLeadsEndpointPostMissingFieldFailure()
    {
        // Create Faker instance to generate lead values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new lead values request
        $response = $this->post($this->leadsEndpoint, [
            'first_name' => $faker->firstName('female'),
            'last_name' => $faker->lastName,
            'company' => $faker->word,
            'lead_status' => $faker->word,
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests the leads endpoint by sending a POST request without a user being logged in, which should
     * result in a response status of 401 and no new lead entry being created.
     * 
     * @return void
     */
    public function testLeadsEndpointPostNoLoginFailure()
    {
        // Create Faker instance to generate lead values
        $faker = Faker::create();

        // Prepare user name for full name field
        $firstName = $faker->firstName('female');
        $lastName = $faker->lastName;
        $fullName = $firstName . " " . $lastName;

        // Send new lead values request
        $response = $this->post($this->leadsEndpoint, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'company' => $faker->word,
            'lead_status' => $faker->word,
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a POST request with a user being logged in, which should
     * result in a response status of 201 and a new lead entry being created.
     * 
     * This test is a dependency for: testLeadsEndpointDelete()
     * 
     * @return void
     */
    public function testLeadsEndpointPost()
    {
        // Create Faker instance to generate lead values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Prepare user name for full name field
        $firstName = $faker->firstName('female');
        $lastName = $faker->lastName;
        $fullName = $firstName . " " . $lastName;

        // Send new lead values request
        $response = $this->post($this->leadsEndpoint, [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'full_name' => $fullName,
            'company' => $faker->word,
            'lead_status' => $faker->word,
            'email_opt_out' => $faker->boolean,
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
     * Tests the leads endpoint by sending a PUT request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testLeadsEndpointPutBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new lead values request
        $response = $this->put($this->leadsEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test user',
            'company' => 'company',
            'lead_status' => 'status',
            'email_opt_out' => true,
            'user_id' => 1
        ]);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the leads endpoint by sending a PUT request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testLeadsEndpointPutNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Send new lead values request
        $response = $this->put($this->leadsEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test user',
            'company' => 'company',
            'lead_status' => 'status',
            'email_opt_out' => true,
            'user_id' => 1
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a PUT request with a user being logged in, which should
     * result in a response status of 200 and an lead entry being updated.
     * 
     * @return void
     */
    public function testLeadsEndpointPut()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new lead values request
        $response = $this->put($this->leadsEndpoint . $id, [
            'first_name' => 'test',
            'last_name' => 'user',
            'full_name' => 'test user',
            'company' => 'company',
            'lead_status' => 'status',
            'email_opt_out' => true,
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
     * Tests the leads endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testLeadsEndpointGetFailure()
    {
        // Get all leads
        $response = $this->get($this->leadsEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testLeadsEndpointGet()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get all leads
        $response = $this->get($this->leadsEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Id Route
     *
     *
     ************************************************************/

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testLeadsEndpointGetByIdBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get lead by id
        $response = $this->get($this->leadsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the leads endpoint by sending a GET request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testLeadsEndpointGetByIdNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Get lead by id
        $response = $this->get($this->leadsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in and a valid entry
     * id, which should result in a response status of 200.
     *
     * @return void
     */
    public function testLeadsEndpointGetById()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get lead by id
        $response = $this->get($this->leadsEndpoint . $id);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Page Route
     *
     *
     ************************************************************/

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in and a empty page
     * value, which should result in a response status of 405.
     *
     * @return void
     */
    public function testLeadsEndpointGetByPageBadPageFailure()
    {
        // Empty page to query
        $page = '';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get leads by page
        $response = $this->get($this->leadsPage . $page);

        $response->assertResponseStatus(405);
    }

    /**
     * Tests the leads endpoint by sending a GET request without a user being logged in and a valid page
     * value, which should result in a response status of 401.
     *
     * @return void
     */
    public function testLeadsEndpointGetByPageNoLoginFailure()
    {
        // Empty page to query
        $page = '1';

        // Get leads by page
        $response = $this->get($this->leadsPage . $page);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a GET request with a user being logged in and a valid page
     * value, which should result in a response status of 200.
     *
     * @return void
     */
    public function testLeadsEndpointGetByPage()
    {
        // Empty page to query
        $page = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get leads by page
        $response = $this->get($this->leadsPage . $page);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Quicklook Route
     *
     *
     ************************************************************/

    /**
     * Tests the leads quicklook endpoint by sending a GET request without a user being logged in, 
     * which should result in a response status of 401 and no lead entries being returned.
     * 
     * @return void
     */
    public function testLeadsEndpointQuicklookFailure()
    {
        // Get quicklook leads
        $response = $this->get($this->leadsQuicklook);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads quicklook endpoint by sending a GET request with a user being logged in, 
     * which should result in a response status of 200 and 10 lead entries being returned.
     * 
     * @return void
     */
    public function testLeadsEndpointQuicklook()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get quicklook leads
        $response = $this->get($this->leadsQuicklook);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Delete Route
     *
     *
     ************************************************************/

    /**
     * Tests the leads endpoint by sending a DELETE request with a user being logged in and with an
     * invalid entry id, which should result in a response status of 404 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testLeadsEndpointDeleteBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->leadsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the leads endpoint by sending a DELETE request without a user being logged in and with an
     * valid entry id, which should result in a response status of 401 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testLeadsEndpointDeleteNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->leadsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the leads endpoint by sending a DELETE request with a user being logged in, which should
     * result in a response status of 200 and the latest entry being deleted.
     * 
     * @depends testLeadsEndpointPost
     * @return void
     */
    public function testLeadsEndpointDelete()
    {
        // Retrieve the id of the latest entry ()
        $latestId = DB::table($this->tableName)->latest('id')->value('id');

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->leadsEndpoint . $latestId);

        $response->assertResponseStatus(200);
    }
}