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
    private static ?PDO $conn = null;

    /**
     * Get the database connection instance.
     *
     * @return PDO The PDO instance representing the database connection.
     */
    public static function getInstance(): PDO
    {
        if (self::$conn === null) {
            try {
                self::$conn = new PDO(DatabaseConfig::DB_DSN, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASS);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }

        return self::$conn;
    }

    // Prevent instantiation and cloning.
    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {}
}