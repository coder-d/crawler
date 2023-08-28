<?php

namespace App\Controllers;

use App\Models\CrawlerModel;
use App\Core\SiteSettings;

class DashBoardController
{
    /**
     * Crawler model instance.
     *
     * @var CrawlerModel
     */
    protected $CrawlerModel;

    /**
     * Site settings instance.
     *
     * @var SiteSettings
     */
    protected $siteSettings;

    /**
     * Constructor to initialize the Crawler model and Site settings.
     *
     * @param CrawlerModel $model    Crawler model object.
     * @param SiteSettings $settings Site settings object.
     */
    public function __construct(CrawlerModel $model, SiteSettings $settings)
    {
        $this->CrawlerModel = $model;
        $this->siteSettings = $settings;
    }

    /**
     * Index method to load the dashboard.
     *
     * @return void
     */
    public function index(): void
    {
        $baseUrl = $this->siteSettings->getBaseUrl();

        if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            $this->redirectTo($baseUrl . 'views/login');
            exit;
        }

        // Fetch the links from the database
        $allLinks = $this->CrawlerModel->fetchLinks();
        
        // Load the view and pass in the links
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }

    /**
     * New method for homepage
     *
     * @return void
     */
    public function showHomepage(): void
    {
        $baseUrl = $this->siteSettings->getBaseUrl();
        require_once __DIR__ . '/../views/public/homepage.php';
    }

    /**
     * Redirect to the given URL.
     *
     * @param string $url URL to redirect to.
     * @return void
     */
    protected function redirectTo(string $url): void
    {
        header('Location: ' . $url);
    }

    /**
     * Show the sitemap.
     *
     * @return void
     */
    public function showSitemap(): void
    {   
        header('Content-Type: text/html');
        readfile(__DIR__ . '/../../sitemap.html');
    }
}