<?php

namespace App\Core;

use PDO;
use PDOException;
use App\Models\CrawlerModel;
use App\Services\CrawlerService;
use App\Core\Observers\CrawlManager;
use App\Core\SiteSettings;
use App\Core\DatabaseConfig;

class Router {
    /**
     * @var array Routes mapped to controllers and methods.
     */
    private $routes = [];

    /**
     * @var PDO Database connection.
     */
    private $pdo;

    /**
     * Router constructor.
     * Initializes the PDO instance.
     */
    public function __construct() {
        try {
            $this->pdo = new PDO(DatabaseConfig::DB_DSN, DatabaseConfig::DB_USER, DatabaseConfig::DB_PASS);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Adds a new route.
     *
     * @param string $uri
     * @param string $controller
     * @param string $method
     */
    public function addRoute(string $uri, string $controller, string $method): void {
        $this->routes[$uri] = ['controller' => $controller, 'method' => $method];
    }

    /**
     * Dispatches to the appropriate controller based on the URI.
     *
     * @param string $uri
     * @param string|null $defaultController
     * @param string $defaultMethod
     */
    public function dispatch(string $uri, ?string $defaultController = null, string $defaultMethod = 'index'): void {
        $settings = new SiteSettings();

        if (array_key_exists($uri, $this->routes)) {
            $controllerName = $this->routes[$uri]['controller'];
            $methodName = $this->routes[$uri]['method'];

            if ($controllerName === 'App\Controllers\CrawlerController') {
                $model = new CrawlerModel($this->pdo);
                $service = new CrawlerService();
                $manager = new CrawlManager($service, $settings);
                $controller = new $controllerName($model, $service, $manager, $settings);
            } elseif ($controllerName === 'App\Controllers\DashBoardController') {
                $model = new CrawlerModel($this->pdo);
                $controller = new $controllerName($model, $settings);
            } elseif ($controllerName === 'App\Controllers\LoginController') {
                $controller = new $controllerName($settings);
            } else {
                $controller = new $controllerName();
            }

            $controller->$methodName();
        } elseif ($defaultController) {
            if ($defaultController === 'App\Controllers\DashBoardController') {
                $model = new CrawlerModel($this->pdo);
                $controller = new $defaultController($model, $settings);
            } else {
                $controller = new $defaultController();
            }
            
            $controller->$defaultMethod();
        } else {
            echo "404 Not Found";
        }
    }

    /**
     * Returns the registered routes.
     *
     * @return array
     */
    public function getRoutes(): array {
        return $this->routes;
    }
}