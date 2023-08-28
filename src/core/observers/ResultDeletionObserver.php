<?php

namespace App\Core\Observers;

use App\Core\Interfaces\ObserverInterface;
use App\Core\DatabaseConfig;
use PDO;

/**
 * Result Deletion Observer
 *
 * Class responsible for responding to events to delete and insert crawl results.
 */
class ResultDeletionObserver implements ObserverInterface
{
    /**
     * @var PDO Database connection.
     */
    private $conn;

    /**
     * Constructor.
     *
     * Establishes a database connection.
     */
    public function __construct()
    {
        $this->conn = new PDO(
            DatabaseConfig::DB_DSN,
            DatabaseConfig::DB_USER,
            DatabaseConfig::DB_PASS
        );
    }

    /**
     * Update
     *
     * Respond to the observed event (crawl action) by deleting previous results and inserting new ones.
     *
     * @param mixed $eventData Data related to the event.
     * @return void
     */
    public function update($eventData): void
    {
        // Clear existing links in the database
        $clearStatement = $this->conn->prepare("DELETE FROM links");
        $clearStatement->execute();

        // Delete existing sitemap.html if it exists
        if (file_exists(__DIR__ . '/../../sitemap.html')) {
            unlink(__DIR__ . '/../../sitemap.html');
        }

        // Insert new links into the database if crawl is completed and has data
        if ($eventData['type'] === 'crawl_completed' && !empty($eventData['data'])) {
            $insertStatement = $this->conn->prepare("INSERT INTO links (url) VALUES (:link)");

            foreach ($eventData['data'] as $link) {
                $insertStatement->bindParam(":link", $link);
                $insertStatement->execute();
            }
        }

        echo "Previous results and sitemap.html have been deleted!<br>";
    }
}