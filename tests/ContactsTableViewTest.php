<?php

/**
 * This file tests the Table View API Endpoints for the Contacts model.
 * 
 * @author 0xChristopher
 */

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ContactsTableViewTest extends TestCase
{
    private $email = 'TEST_USERNAME';                               // Test username environment variable
    private $password = 'TEST_PASSWORD';                            // Test password environment variable
    private $tableName = 'contacts';                                // Name of the table we're working in
    private $viewName = 'default';                                  // Name of the table view requested
    private $loginEndpoint = 'api/v1/users/login/';                 // API Login Endpoint
    private $tableViewEndpoint = 'api/v1/tableview/';               // API Table View Endpoint

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
     * Get Route
     *
     *
     ************************************************************/

    /**
     * Tests the table view endpoint by sending a GET request without a user being logged in, which should
     * result in a response status of 401.
     *
     * @return void
     */
    public function testTableViewEndpointGetByNameNoLoginFailure()
    {
        // Get default accounts table view
        $response = $this->get($this->tableViewEndpoint . $this->tableName . '/' . $this->viewName);

        $response->assertResponseStatus(401);
    }

    /**
     * Tests the table view endpoint by sending a GET request with a user being logged in and an invalid
     * table view name, which should result in a response status of 404.
     *
     * @return void
     */
    public function testTableViewEndpointGetByNameInvalidTableViewNameFailure()
    {
        $invalidTableView = 'invalidview';

        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);
        
        // Get default accounts table view
        $response = $this->get($this->tableViewEndpoint . $this->tableName . '/' . $invalidTableView);

        $response->assertResponseStatus(404);
    }

    /**
     * Tests the table view endpoint by sending a GET request with a user being logged in, which should
     * result in a response status of 200.
     *
     * @return void
     */
    public function testTableViewEndpointGetByName()
    {
        // Login the test user
        $this->login($this->loginEndpoint, $this->email, $this->password);

        // Get default accounts table view
        $response = $this->get($this->tableViewEndpoint . $this->tableName . '/' . $this->viewName);

        $response->assertResponseStatus(200);
    }
}