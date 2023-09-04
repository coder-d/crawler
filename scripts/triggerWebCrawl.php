<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\CrawlerController;
use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\SiteSettings;
use App\Core\Database;

// Get the PDO instance
$pdo = Database::getInstance();

// Initialize dependencies
$model = new CrawlerModel($pdo);
$service = new CrawlerService();
$crawlManager = new CrawlManager($service, new SiteSettings());

// Initialize CrawlerController
$crawlerController = new CrawlerController($model, $service, $crawlManager, new SiteSettings());

// Trigger the crawl
$crawlerController->crawlHomepage();