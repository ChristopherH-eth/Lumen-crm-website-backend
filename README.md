# CRM Backend

This is the repository of the CRM Backend - part of the CRM Fullstack Application.

## High Level Overview

The CRM Backend handles various client requests through a REST API and MVC architecture and runs on the Laravel Lumen framework. It handles user authentication, manages user sessions, and interacts with the MySQL database before sending responses back up to the client(s). While external API access may be implemented in the future, the CRM Backend is currently designed to work with the client-side frontend found [here](https://github.com/ChristopherH-eth/React-crm-website-frontend).

Current API endpoints include:

-   User Login and Registration
-   Posting of new Contacts, Accounts, Leads, Opportunities, and Users
-   Getting, updating, and deleting those entries
-   Refreshing the current user's access token (this is set to happen automatically on the frontend by default)
-   Storing a user's current session

## Test Data

To populate the database with test data using Docker Containers, first in the terminal run:

```
docker exec -it crm-website-backend-lumen-1 /bin/bash
```

Navigate to the 'scripts' folder located at '/var/html/www/scripts/dbtestdata.sh'. Then execute the DB Test Data script:

```
./dbtestdata.sh
```

## Setting Up Environment Variables

The CRM API requires several environment variables to setup for it to function. This should be done in the .env file in the root directory of the codebase.

### Database

Because this system was build with a MySQL database in mind, the following are the environment variables needed to interact with MySQL. Brackets [] denote variables that should be filled in:

```
DB_CONNECTION=mysql
DB_HOST=[Your local machine IP or DB container name]
DB_PORT=3306
DB_DATABASE=[Name of the Database]
DB_USERNAME=[Username]
DB_PASSWORD=[Password]
```

The DB_CONNECTION variable defines the type of database Lumen will be interacting with. While there are several, this API is built with MySQL in mind.

For the DB_HOST variable, you can choose to use your local machine if using a development server, like the one that PHP has built in, or the container name in the Dockerfile can be used when implementing Docker.

The DB_PORT variable defines the port that the associated database is listening on. The default for MySQL is 3306.

The DB_DATABASE variable indicates the MySQL schema, as they're referred to, to use.

DB_USERNAME and DB_PASSWORD are the variables used to log into the database.

### Cache and Queue

```
CACHE_DRIVER=file
QUEUE_CONNECTION=database
```

The CACHE_DRIVER variable with the 'file' value tells Lumen that the API cache should be stored in a file.

The QUEUE_CONNECTION variable with the 'database' value tells Lumen that it should use the database when queueing jobs (when jobs are used).

### Sessions

This API uses sessions from Laravel, and makes use of the following:

```
SESSION_DRIVER=cookie
```

The SESSION_DRIVER variable with the 'cookie' value tells Lumen that user sessions should be stored in cookies.

### JSON Web Tokens

Since this API uses JWTs for request authorization, the following environment variables are necessary, but can be modified slightly to suite your needs:

```
JWT_SECRET=[YourSecret]
JWT_TTL=5
JWT_BLACKLIST_GRACE_PERIOD=10
```

The JWT_SECRET variable is used by the implemented JWT package for encoding and decoding tokens.

The JWT_TTL variable is the time (in minutes) that a JWT is valid, in this case, 5 minutes. After that, the token is considered expires, and can no longer be used to authorize sent requests.

The JWT_BLACKLIST_GRACE_PERIOD variable is used to offer a grace period (in seconds) for expiring tokens, in this case, 10 seconds. This is useful so that the user experience is not interrupted because they just happened to make a request as their token was being refreshed, resulting in an error and/or missed request.
