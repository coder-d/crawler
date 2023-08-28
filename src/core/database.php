<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Class Database
 *
 * This class is responsible for database operations.
 */
class Database
{
    /**
     * @var PDO|null Database connection
     */
    private ?PDO $conn = null;

    /**
     * Connect to the database.
     *
     * @return PDO The PDO instance representing the database connection.
     */
    public function connect(): PDO
    {
        try {
            $this->conn = new PDO(DatabaseConfig::DB_DSN, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASS);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conn;
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }
}