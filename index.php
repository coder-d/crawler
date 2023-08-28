<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require __DIR__ . '/vendor/autoload.php';

use App\Core\Router;
use App\Core\SiteSettings;
use App\Controllers\DashBoardController;
use App\Controllers\CrawlerController;
use App\Controllers\LoginController;

session_start();

$settings = new SiteSettings();
$baseDirectory = $settings->getBaseDirectory();

$router = new Router();
//echo "Requested URI: " . $_SERVER['REQUEST_URI'];

// Define routes taking into account the base directory.
$router->addRoute($baseDirectory . 'views/sitemap', DashBoardController::class, 'showSitemap');
$router->addRoute($baseDirectory . 'views/public/homepage', DashBoardController::class, 'showHomepage');
$router->addRoute($baseDirectory . 'views/login', LoginController::class, 'showLoginForm');
$router->addRoute($baseDirectory . 'views/do-login', LoginController::class, 'login');
$router->addRoute($baseDirectory . 'views/admin/dashboard', DashBoardController::class, 'index');
$router->addRoute($baseDirectory . 'views/admin/crawl', CrawlerController::class, 'crawlHomepage');

// Dispatch request
$router->dispatch($_SERVER['REQUEST_URI'], DashboardController::class);  // Defaults to DashboardController if no route matches
