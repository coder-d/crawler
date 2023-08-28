<?php

namespace App\Controllers;

use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\Observers\ResultDeletionObserver;
use App\Core\SiteSettings;

class CrawlerController
{
    private CrawlerModel $model;
    private CrawlerService $service;
    private CrawlManager $crawlManager;
    private SiteSettings $siteSettings;

    /**
     * Constructor to initialize dependencies.
     *
     * @param CrawlerModel  $model        Crawler model object.
     * @param CrawlerService $service     Crawler service object.
     * @param CrawlManager  $crawlManager Crawler manager object.
     * @param SiteSettings  $siteSettings Site settings object.
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

        // Adding observers to the crawl manager
        $this->crawlManager->addObserver(new ResultDeletionObserver($this->model));
    }

    /**
     * Crawls the homepage and echoes the number of links extracted.
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
     * Triggers the crawling process.
     *
     * @return array The array of links crawled.
     */
    public function triggerCrawl(): array
    {
        return $this->crawlManager->crawl();
    }

    /**
     * Displays the results of the crawl operation.
     *
     * @return array The array of links that were crawled.
     */
    public function displayResults(): array
    {
        $links = $this->model->fetchLinks();
        return $links;
    }
}