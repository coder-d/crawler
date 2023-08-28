<?php

namespace App\Models;

use PDO;

/**
 * CrawlerModel Class
 *
 * This class is responsible for database operations related to crawling.
 */
class CrawlerModel {
    /**
     * @var PDO Database connection.
     */
    private $conn;

    /**
     * Constructor.
     *
     * @param PDO $pdo The PDO instance.
     */
    public function __construct(PDO $pdo) {
        $this->conn = $pdo;
    }

    /**
     * Saves extracted links to the database.
     *
     * @param array $links Array of links.
     * @return void
     */
    public function saveLinks(array $links): void {
        $insertStatement = $this->conn->prepare("INSERT INTO links (url) VALUES (:url)");
        
        foreach ($links as $link) {
            $insertStatement->bindParam(':url', $link);
            $insertStatement->execute();
        }
    }

    /**
     * Fetches all the links from the database.
     *
     * @return array The links from the database.
     */
    public function fetchLinks(): array {
        $statement = $this->conn->prepare("SELECT url FROM links");
        $statement->execute();
        
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Clears all the links from the database.
     *
     * @return void
     */
    public function clearLinks(): void {
        $clearStatement = $this->conn->prepare("DELETE FROM links");
        
        if (!$clearStatement->execute()) {
            print_r($clearStatement->errorInfo());
        }
    }
}