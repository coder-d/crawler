<?php

namespace Tests\Controllers;

use PHPUnit\Framework\TestCase;
use App\Controllers\CrawlerController;
use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\SiteSettings;

class CrawlerControllerTest extends TestCase
{
    private $controller;
    private $modelMock;
    private $serviceMock;
    private $managerMock;
    private $settingsMock;

    protected function setUp(): void
    {
        $this->modelMock = $this->createMock(CrawlerModel::class);
        $this->serviceMock = $this->createMock(CrawlerService::class);
        $this->managerMock = $this->createMock(CrawlManager::class);
        $this->settingsMock = $this->createMock(SiteSettings::class);

        $this->controller = new CrawlerController(
            $this->modelMock,
            $this->serviceMock,
            $this->managerMock,
            $this->settingsMock
        );
    }

    public function testCrawlHomepage(): void
    {
        // Assuming crawl returns an empty array for simplicity
        $this->managerMock->method('crawl')->willReturn([]);
        $this->expectOutputString('Extracted 0 links!Crawling completed!');

        $this->controller->crawlHomepage();
    }

    public function testTriggerCrawl(): void
    {
        // Assume the manager's crawl method returns some links for testing
        $this->managerMock->method('crawl')->willReturn(['link1', 'link2']);

        $result = $this->controller->triggerCrawl();

        $this->assertEquals(['link1', 'link2'], $result);
    }

    public function testDisplayResults(): void
    {
        // Assuming fetchLinks returns an array of links
        $this->modelMock->method('fetchLinks')->willReturn(['linkA', 'linkB']);

        $links = $this->controller->displayResults();

        $this->assertEquals(['linkA', 'linkB'], $links);
    }
}