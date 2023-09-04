<?php
require_once __DIR__ . '/../vendor/autoload.php';  // Assuming Composer autoloader

use App\Core\WebCrawler;

$crawler = new WebCrawler();
$crawler->crawl();
