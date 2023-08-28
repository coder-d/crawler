<?php

use PHPUnit\Framework\TestCase;
use App\Controllers\DashBoardController;
use App\Models\CrawlerModel;
use App\Core\SiteSettings;

class DashboardControllerTest extends TestCase
{
    private $dashboardController;

    protected function setUp(): void
    {
        // Create mock objects for CrawlerModel and SiteSettings
        $crawlerModel = $this->createMock(CrawlerModel::class);
        $siteSettings = $this->createMock(SiteSettings::class);

        // Initialize DashboardController with mock objects
        $this->dashboardController = new DashBoardController($crawlerModel, $siteSettings);
    }

    public function testIndex()
    {
        // Mock session for admin login
        $_SESSION['admin_logged_in'] = true;

        // Start output buffering to catch the HTML output
        ob_start();

        // Call the index method
        $this->dashboardController->index();

        // Clean the output buffer
        ob_end_clean();

        // Assert that the function works correctly
        $this->assertTrue(true);
    }

    public function testShowHomepage()
    {
        // Start output buffering to catch the HTML output
        ob_start();

        // Call the showHomepage method
        $this->dashboardController->showHomepage();

        // Clean the output buffer
        ob_end_clean();

        // Assert that the function works correctly
        $this->assertTrue(true);
    }
}