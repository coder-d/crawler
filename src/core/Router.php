<?php

namespace App\Core;

use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\SiteSettings;

class Router {
    private $routes = [];

    public function __construct() {
        // No need to initialize PDO here. Will use Database::getInstance() where needed.
    }

    public function addRoute(string $uri, string $controller, string $method): void {
        $this->routes[$uri] = ['controller' => $controller, 'method' => $method];
    }

    public function dispatch(string $uri, ?string $defaultController = null, string $defaultMethod = 'index'): void {
        $settings = new SiteSettings();
        $pdo = Database::getInstance();

        if (array_key_exists($uri, $this->routes)) {
            $controllerName = $this->routes[$uri]['controller'];
            $methodName = $this->routes[$uri]['method'];

            $controller = $this->initializeController($controllerName, $pdo, $settings);
            $controller->$methodName();
        } elseif ($defaultController) {
            $controller = $this->initializeController($defaultController, $pdo, $settings);
            $controller->$defaultMethod();
        } else {
            echo "404 Not Found";
        }
    }

    private function initializeController(string $controllerName, $pdo, $settings) {
        if ($controllerName === 'App\Controllers\CrawlerController') {
            $model = new CrawlerModel($pdo);
            $service = new CrawlerService();
            $manager = new CrawlManager($service, $settings);
            return new $controllerName($model, $service, $manager, $settings);
        } elseif ($controllerName === 'App\Controllers\DashBoardController') {
            $model = new CrawlerModel($pdo);
            return new $controllerName($model, $settings);
        } elseif ($controllerName === 'App\Controllers\LoginController') {
            return new $controllerName($settings);
        } else {
            return new $controllerName();
        }
    }

    public function getRoutes(): array {
        return $this->routes;
    }
}