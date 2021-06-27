# Mars Rover Study
This study developed by using Symfony Framework, MySQL, Chain Of Responsibility Design Pattern, 
Unit Tests and Swagger API Documentation.

#### Local Development

Before starting the server don't forget to edit your own `.env` file to be able to work without any issue.

Also, to be able to have tables, create the migration command like:
* bin/console make:migration

#### Api Documentation

* Start the development server with: `symfony server:start`
* Then go to http://localhost:8000/api/doc or http://localhost:8000/api/doc.json

#### Unit Tests

* Run tests: `php bin/phpunit tests`
