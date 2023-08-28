
## The Problem To Be Solved
In simple terms, the problem we are looking to solve is to create a simplified PHP Web Crawler application that can scrape websites and collect data, specifically the links on the homepages of websites. Since we not focusing on the login,to keep it simple a hardcoded login logic is implement using the MVC and Observer design patterns. The admin should be able to view the scraped data on their dashboard.

## Technical Spec: How To Solve It
To tackle this problem, the plan is to:

Build the backend in PHP, utilizing the Model-View-Controller (MVC) design patterns.
Use the PDO library for database interactions.
Implement a Crawler Service that performs the actual scraping.
Use Observer pattern to listen for crawl events and trigger database updates.
Create a simple hardcoded login mechanism to protect the admin dashboard.
## Technical Decisions and Why
Choice of PHP
PHP is widely used for web development and has robust features for backend development. Its rich ecosystem and readily available libraries make it an excellent choice for this project.

## Model-View-Controller (MVC)
Using MVC helps to separate the application logic, user interface, and data. This separation is particularly useful for maintainability and scalability.

## Observer Pattern
This pattern was implemented for greater extensibility, allowing us to easily add more features or triggers that respond to crawl events in the future.

## Hardcoded Login
This was done to keep the application simplified, focusing more on the crawler logic than on user authentication.

## How the Code Works
CrawlerController: This is the entry point that triggers the web crawling.
CrawlerService: This service class is responsible for the actual web scraping.
CrawlManager: Manages the crawling operations and notifies all observers once crawling is done.
ResultDeletionObserver: An observer that listens for the crawl completion event and updates the database accordingly.
Database: Utilizes PDO for database interactions and follows the Singleton pattern.
You can trigger the crawl by navigating to the homepage, which is accessible at http://localhost/sub_dir/views/public/homepage after a successful login.

## How This Achieves the Admin's Desired Outcome
The admin can initiate a web crawl through the homepage and then view the crawled data on their admin dashboard. This adheres to the requirements laid out in the user story.

## Thought Process
How I Approach a Problem
I start by breaking down the problem into smaller, more manageable tasks. I then tackle these tasks one by one, testing as I go.

Why This Direction
I chose this direction because it follows well-established design patterns, which makes the codebase easier to understand and extend. It also makes efficient use of resources by updating the database only when a crawl is complete.

Why This is a Better Solution
This solution is structured, extendable, and focuses on both performance and scalability. By following best practices and design patterns, we've laid a strong foundation for future development.