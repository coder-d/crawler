<?php

namespace Tests;

use App\Models\CrawlerModel;
use PHPUnit\Framework\TestCase;
use PDO;

class CrawlerModelTest extends TestCase
{
    private $crawlerModel;
    private $pdo;

    // Set up a new instance of CrawlerModel for each test
    protected function setUp(): void
    {
        parent::setUp();

        $this->pdo = new PDO(TestDatabaseConfig::DB_DSN, TestDatabaseConfig::DB_USER, TestDatabaseConfig::DB_PASS);

        // Start the transaction.
        $this->pdo->beginTransaction();

        // Passing this PDO instance to the model.The CrawlerModel should accept a PDO object.
        $this->crawlerModel = new CrawlerModel($this->pdo);
    }

    // This method will run after each test, rolling back the transaction
    protected function tearDown(): void
    {
        $this->pdo->rollBack();
        parent::tearDown();
    }

    public function testSaveLinks()
    {
        $links = ['https://example.com', 'https://test.com'];
        $this->crawlerModel->saveLinks($links);

        $savedLinks = $this->crawlerModel->fetchLinks();

        $this->assertEquals($links, array_column($savedLinks, 'url'));
    }

    public function testFetchLinks()
    {
        $links = ['https://example.com', 'https://test.com'];
        $this->crawlerModel->saveLinks($links);

        $fetchedLinks = $this->crawlerModel->fetchLinks();

        $this->assertEquals($links, array_column($fetchedLinks, 'url'));
    }

    public function testClearLinks()
    {
        $links = ['https://example.com', 'https://test.com'];
        $this->crawlerModel->saveLinks($links);

        $this->crawlerModel->clearLinks();
        $clearedLinks = $this->crawlerModel->fetchLinks();

        $this->assertEmpty($clearedLinks);
    }
}