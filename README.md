# Crawler 

A simplified PHP Web Crawler application featuring hard-coded login logic. The project employs MVC and Observer design patterns and includes test cases.

## Table of Contents
1. [Installation](#installation)
2. [Database Setup](#database-setup)
3. [Configuration](#configuration)
4. [Design Patterns](#design-patterns)
5. [Test Cases](#test-cases)
6. [Git Ignore](#git-ignore)
7. [Miscellaneous](#miscellaneous)

## Installation

- Clone the repository to your local machine.
- Navigate to the project directory.
- Run `composer install` to install all required package

## For Development
--Run the following SQL script to set up the crawler database:
	
	CREATE DATABASE crawler;
	USE crawler;

	CREATE TABLE pages (
		id INT PRIMARY KEY AUTO_INCREMENT,
		url VARCHAR(255) NOT NULL,
		content TEXT,
		timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);


## For Testing
--Run the following SQL script to set up the crawler_test database:
	
	CREATE DATABASE crawler_test;
	USE crawler_test;

	CREATE TABLE pages (
		id INT PRIMARY KEY AUTO_INCREMENT,
		url VARCHAR(255) NOT NULL,
		content TEXT,
		timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);


## Configuration
--Rename DatabaseConfig.php.env to DatabaseConfig.php, SiteSettings.php.env to SiteSettings.php and TestDatabaseConfig.php.env to TestDatabaseConfig.php
--Update DatabaseConfig.php and SiteSettings.php with your actual settings.
--Update TestDatabaseConfig.php with your test database settings.

Links
Home Page: http://localhost/sub_dir/views/public/homepage
Login Page: http://localhost/sub_dir/views/login
Admin Dashboard: http://localhost/sub_dir/views/admin/dashboard

Design Patterns
## MVC
The application uses the Model-View-Controller (MVC) pattern to manage the codebase effectively.

## Observer Pattern
The Observer Pattern is implemented to provide a more flexible and extendable architecture. This pattern allows us to define a one-to-many dependency between objects so that when one object changes state, all its dependents are notified and updated automatically. In our project, this is particularly useful for updating the database once a web crawl is complete. This ensures efficient use of resources and makes it easier to add more features or triggers that respond to crawl events in the future.


## Test Cases
To run the test cases:

Navigate to the project directory.
--Run phpunit --configuration phpunit.xml.
Note for Test Cases
If your web server and CLI have different localhost settings, set the BASE_URL dynamically in the CLI before running PHPUnit tests:
export BASE_URL=http://your.cli.localhost/

## Miscellaneous
The login logic is hard-coded for simplification.
Manual updates to DatabaseConfig.php and TestDatabaseConfig.php are necessary