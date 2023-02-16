<?php

class Database
{
    private $username = "CHardy";
    private $password = "TestCHardy";

    function connectToDB()
    {
        echo "Connecting to database...\n";

        $client = new MongoDB\Driver\Manager(
            "mongodb+srv://CHardy:TestCHardy@cluster0.2tcgcpm.mongodb.net/?retryWrites=true&w=majority"
        );

        echo "Database connection successful\n";

        return $client;
    }
}
