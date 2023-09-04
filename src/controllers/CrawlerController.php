<?php

namespace App\Controllers;

use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\Observers\ResultDeletionObserver;
use App\Core\Observers\CronJobObserver;
use App\Core\Observers\SavePageObserver;
use App\Core\SiteSettings;

/**
 * CrawlerController Class
 *
 * This class is responsible for handling web crawling operations.
 * It utilizes observer design pattern for extensibility and modularity.
 */
class CrawlerController
{
    /**
     * @var CrawlerModel
     */
    private $model;

    /**
     * @var CrawlerService
     */
    private $service;

    /**
     * @var CrawlManager
     */
    private $crawlManager;

    /**
     * @var SiteSettings
     */
    private $siteSettings;

    /**
     * CrawlerController constructor
     *
     * @param CrawlerModel $model
     * @param CrawlerService $service
     * @param CrawlManager $crawlManager
     * @param SiteSettings $siteSettings
     */
    public function __construct(
        CrawlerModel $model,
        CrawlerService $service,
        CrawlManager $crawlManager,
        SiteSettings $siteSettings
    ) {
        $this->model = $model;
        $this->service = $service;
        $this->crawlManager = $crawlManager;
        $this->siteSettings = $siteSettings;

        // Register the observers
        $this->crawlManager->addObserver(new ResultDeletionObserver());
        $this->crawlManager->addObserver(new CronJobObserver(__DIR__ . '/../../scripts', $this->siteSettings));
        $this->crawlManager->addObserver(new SavePageObserver($this->siteSettings));
    }

    /**
     * Initiates a crawl operation for the homepage and outputs the count of extracted links
     *
     * @return void
     */
    public function crawlHomepage(): void
    {
        $links = $this->triggerCrawl();
        echo 'Extracted ' . count($links) . ' links!';
        echo 'Crawling completed!';
    }

    /**
     * Triggers the crawl operation by delegating to CrawlManager
     *
     * @return array
     */
    public function triggerCrawl(): array
    {
        return $this->crawlManager->crawl();
    }

    /**
     * Fetches the results of the crawling operation from the database
     *
     * @return array
     */
    public function displayResults(): array
    {
        return $this->model->fetchLinks();
    }
}