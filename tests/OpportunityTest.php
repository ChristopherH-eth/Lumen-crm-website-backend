<?php

/**
 * This file tests the Opportunities API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class OpportunityTest extends TestCase
{
    private $email = 'TEST_USERNAME';                                       // Test username environment variable
    private $password = 'TEST_PASSWORD';                                    // Test password environment variable
    private $tableName = 'opportunities';                                   // Name of the table we're working in
    private $loginEndpoint = 'api/v1/users/login/';                         // API Login Endpoint
    private $opportunitiesEndpoint = 'api/v1/opportunities/';               // API Opportunities Endpoint
    private $opportunitiesPage = 'api/v1/opportunities/page/';              // API Opportunities Page Endpoint
    private $opportunitiesQuicklook = 'api/v1/opportunities/quicklook/';    // API Opportunities Quicklook

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
     * Tests the opportunities endpoint by sending a POST request with a user being logged in and missing
     * fields, which should result in a response status of 422 and a no new opportunity entry being created.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointPostMissingFieldFailure()
    {
        // Create Faker instance to generate opportunity values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new opportunity values request
        $response = $this->post($this->opportunitiesEndpoint, [
            'last_name' => $faker->lastName,
            'account_id' => $faker->numberBetween(1, 10),
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests the opportunities endpoint by sending a POST request without a user being logged in, which should
     * result in a response status of 401 and no new opportunity entry being created.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointPostNoLoginFailure()
    {
        // Create Faker instance to generate opportunity values
        $faker = Faker::create();

        // Send new opportunity values request
        $response = $this->post($this->opportunitiesEndpoint, [
            'first_name' => $faker->firstName('female'),
            'last_name' => $faker->lastName,
            'account_id' => $faker->numberBetween(1, 10),
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a POST request with a user being logged in, which should
     * result in a response status of 201 and a new opportunity entry being created.
     * 
     * This test is a dependency for: testOpportunitiesEndpointDelete()
     * 
     * @return void
     */
    public function testOpportunitiesEndpointPost()
    {
        // Create Faker instance to generate opportunity values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new opportunity values request
        $response = $this->post($this->opportunitiesEndpoint, [
            'opportunity_name' => $faker->name,
            'follow_up' => $faker->boolean,
            'close_date' => $faker->dateTime($max = 'now', $timezone = null),
            'stage' => $faker->word,
            'account_id' => $faker->numberBetween(1, 10),
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
     * Tests the opportunities endpoint by sending a PUT request with a user being logged in and a invalid 
     * entry id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testOpportunitiesEndpointPutBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new opportunity values request
        $response = $this->put($this->opportunitiesEndpoint . $id, [
            'opportunity_name' => 'test',
            'follow_up' => true,
            'close_date' => '1990-05-07 02:07:44',
            'stage' => 'stage',
            'account_id' => 1,
            'user_id' => 1
        ]);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the opportunities endpoint by sending a PUT request without a user being logged in and a valid 
     * entry id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testOpportunitiesEndpointPutNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Send new opportunity values request
        $response = $this->put($this->opportunitiesEndpoint . $id, [
            'opportunity_name' => 'test',
            'follow_up' => true,
            'close_date' => '1990-05-07 02:07:44',
            'stage' => 'stage',
            'account_id' => 1,
            'user_id' => 1
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a PUT request with a user being logged in, which should
     * result in a response status of 200 and an opportunity entry being updated.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointPut()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new opportunity values request
        $response = $this->put($this->opportunitiesEndpoint . $id, [
            'opportunity_name' => 'test',
            'follow_up' => true,
            'close_date' => '1990-05-07 02:07:44',
            'stage' => 'stage',
            'account_id' => 1,
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
     * Tests the opportunities endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetFailure()
    {
        // Get all opportunities
        $response = $this->get($this->opportunitiesEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGet()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get all opportunities
        $response = $this->get($this->opportunitiesEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Id Route
     *
     *
     ************************************************************/

    /**
     * Tests the opportunities endpoint by sending a GET request with a user being logged in and a invalid 
     * entry id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetByIdBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get opportunity by id
        $response = $this->get($this->opportunitiesEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the opportunities endpoint by sending a GET request without a user being logged in and a valid 
     * entry id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetByIdNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Get opportunity by id
        $response = $this->get($this->opportunitiesEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a GET request with a user being logged in and a valid 
     * entry id, which should result in a response status of 200.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetById()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get opportunity by id
        $response = $this->get($this->opportunitiesEndpoint . $id);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Page Route
     *
     *
     ************************************************************/

    /**
     * Tests the opportunities endpoint by sending a GET request with a user being logged in and a empty page
     * value, which should result in a response status of 405.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetByPageBadPageFailure()
    {
        // Empty page to query
        $page = '';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get opportunities by page
        $response = $this->get($this->opportunitiesPage . $page);

        $response->assertResponseStatus(405);
    }

    /**
     * Tests the opportunities endpoint by sending a GET request without a user being logged in and a valid 
     * page value, which should result in a response status of 401.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetByPageNoLoginFailure()
    {
        // Empty page to query
        $page = '1';

        // Get opportunities by page
        $response = $this->get($this->opportunitiesPage . $page);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a GET request with a user being logged in and a valid page
     * value, which should result in a response status of 200.
     *
     * @return void
     */
    public function testOpportunitiesEndpointGetByPage()
    {
        // Empty page to query
        $page = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get opportunities by page
        $response = $this->get($this->opportunitiesPage . $page);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Quicklook Route
     *
     *
     ************************************************************/

    /**
     * Tests the opportunities quicklook endpoint by sending a GET request without a user being logged in, 
     * which should result in a response status of 401 and no opportunity entries being returned.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointQuicklookFailure()
    {
        // Get quicklook opportunities
        $response = $this->get($this->opportunitiesQuicklook);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities quicklook endpoint by sending a GET request with a user being logged in, 
     * which should result in a response status of 200 and 10 opportunity entries being returned.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointQuicklook()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get quicklook opportunities
        $response = $this->get($this->opportunitiesQuicklook);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Delete Route
     *
     *
     ************************************************************/

    /**
     * Tests the opportunities endpoint by sending a DELETE request with a user being logged in and with an
     * invalid entry id, which should result in a response status of 404 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointDeleteBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->opportunitiesEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the opportunities endpoint by sending a DELETE request without a user being logged in and with an
     * valid entry id, which should result in a response status of 401 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testOpportunitiesEndpointDeleteNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->opportunitiesEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the opportunities endpoint by sending a DELETE request with a user being logged in, which should
     * result in a response status of 200 and the latest entry being deleted.
     * 
     * @depends testOpportunitiesEndpointPost
     * @return void
     */
    public function testOpportunitiesEndpointDelete()
    {
        // Retrieve the id of the latest entry ()
        $latestId = DB::table($this->tableName)->latest('id')->value('id');

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->opportunitiesEndpoint . $latestId);

        $response->assertResponseStatus(200);
    }
}