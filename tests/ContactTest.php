<?php

/**
 * This file tests the Contacts API Endpoints.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ContactTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $tableName = 'contacts';                                // Name of the table we're working in
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $contactsEndpoint = 'api/v1/contacts/';                 // API Contacts Endpoint
    private $contactsQuicklook = 'api/v1/contacts/quicklook/';      // API Contacts Quicklook

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
     * Tests the contacts endpoint by sending a POST request with a user being logged in and missing
     * fields, which should result in a response status of 422 and a no new contact entry being created.
     * 
     * @return void
     */
    public function testContactsEndpointPostMissingFieldFailure()
    {
        // Create Faker instance to generate contact values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new contact values request
        $response = $this->post($this->contactsEndpoint, [
            'last_name' => $faker->lastName,
            'account_id' => $faker->numberBetween(1, 10),
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(422);
    }

    /**
     * Tests the contacts endpoint by sending a POST request without a user being logged in, which should
     * result in a response status of 401 and no new contact entry being created.
     * 
     * @return void
     */
    public function testContactsEndpointPostNoLoginFailure()
    {
        // Create Faker instance to generate contact values
        $faker = Faker::create();

        // Send new contact values request
        $response = $this->post($this->contactsEndpoint, [
            'first_name' => $faker->firstName('female'),
            'last_name' => $faker->lastName,
            'account_id' => $faker->numberBetween(1, 10),
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the contacts endpoint by sending a POST request with a user being logged in, which should
     * result in a response status of 201 and a new contact entry being created.
     * 
     * This test is a dependency for: testContactsEndpointDelete()
     * 
     * @return void
     */
    public function testContactsEndpointPost()
    {
        // Create Faker instance to generate contact values
        $faker = Faker::create();

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Send new contact values request
        $response = $this->post($this->contactsEndpoint, [
            'first_name' => $faker->firstName('female'),
            'last_name' => $faker->lastName,
            'account_id' => $faker->numberBetween(1, 10),
            'email_opt_out' => $faker->boolean,
            'user_id' => $faker->numberBetween(1, 10)
        ]);

        $response->assertResponseStatus(201);
    }

    /************************************************************
     * Get Route
     *
     *
     ************************************************************/

    /**
     * Tests the contacts endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testContactsEndpointGetFailure()
    {
        // Get all contacts
        $response = $this->get($this->contactsEndpoint);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the contacts endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testContactsEndpointGet()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get all contacts
        $response = $this->get($this->contactsEndpoint);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Id Route
     *
     *
     ************************************************************/

    /**
     * Tests the contacts endpoint by sending a GET request with a user being logged in and a invalid entry
     * id, which should result in a response status of 404.
     *
     * @return void
     */
    public function testContactsEndpointGetByIdBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get contact by id
        $response = $this->get($this->contactsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the contacts endpoint by sending a GET request without a user being logged in and a valid entry
     * id, which should result in a response status of 401.
     *
     * @return void
     */
    public function testContactsEndpointGetByIdNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Get contact by id
        $response = $this->get($this->contactsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the contacts endpoint by sending a GET request with a user being logged in and a valid entry
     * id, which should result in a response status of 200.
     *
     * @return void
     */
    public function testContactsEndpointGetById()
    {
        // Entry id to query
        $id = '1';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get contact by id
        $response = $this->get($this->contactsEndpoint . $id);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Get/Quicklook Route
     *
     *
     ************************************************************/

    /**
     * Tests the contacts quicklook endpoint by sending a GET request without a user being logged in, 
     * which should result in a response status of 401 and no contact entries being returned.
     * 
     * @return void
     */
    public function testContactsEndpointQuicklookFailure()
    {
        // Get quicklook contacts
        $response = $this->get($this->contactsQuicklook);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the contacts quicklook endpoint by sending a GET request with a user being logged in, 
     * which should result in a response status of 200 and 10 contact entries being returned.
     * 
     * @return void
     */
    public function testContactsEndpointQuicklook()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get quicklook contacts
        $response = $this->get($this->contactsQuicklook);

        $response->assertResponseStatus(200);
    }

    /************************************************************
     * Delete Route
     *
     *
     ************************************************************/

    /**
     * Tests the contacts endpoint by sending a DELETE request with a user being logged in and with an
     * invalid entry id, which should result in a response status of 404 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testContactsEndpointDeleteBadIdFailure()
    {
        // Entry id to query
        $id = '99999';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->contactsEndpoint . $id);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the contacts endpoint by sending a DELETE request without a user being logged in and with an
     * valid entry id, which should result in a response status of 401 and the latest entry not
     * being deleted.
     * 
     * @return void
     */
    public function testContactsEndpointDeleteNoLoginFailure()
    {
        // Entry id to query
        $id = '1';

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->contactsEndpoint . $id);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the contacts endpoint by sending a DELETE request with a user being logged in, which should
     * result in a response status of 200 and the latest entry being deleted.
     * 
     * @depends testContactsEndpointPost
     * @return void
     */
    public function testContactsEndpointDelete()
    {
        // Retrieve the id of the latest entry ()
        $latestId = DB::table($this->tableName)->latest('id')->value('id');

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Attempt to delete the latest entry by id
        $response = $this->delete($this->contactsEndpoint . $latestId);

        $response->assertResponseStatus(200);
    }
}