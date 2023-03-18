# CRM Backend

This is the repository of the CRM Backend - part of the CRM Fullstack Application.

## High Level Overview

The CRM Backend handles various client requests through a REST API and MVC architecture and runs on the Laravel Lumen framework. It handles user authentication, manages user sessions, and interacts with the MySQL database before sending responses back up to the client(s). While external API access may be implemented in the future, the CRM Backend is currently designed to work with the client-side frontend found [here](https://github.com/ChristopherH-eth/React-crm-website-frontend).

Current API endpoints include:

-   User Login and Registration
-   Posting of new Contacts, Accounts, Leads, and Users
-   Getting, updating, and deleting those entries
-   Refreshing the current user's access token (this is set to happen automatically on the frontend by default)
