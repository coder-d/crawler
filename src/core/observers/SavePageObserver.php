<?php

namespace App\Core\Observers;

use App\Core\Interfaces\ObserverInterface;
use App\Core\SiteSettings;

/**
 * Class SavePageObserver
 *
 * Observer responsible for saving the homepage as an HTML file.
 */
class SavePageObserver implements ObserverInterface
{
    /**
     * @var SiteSettings
     */
    private $siteSettings;

    /**
     * SavePageObserver constructor.
     *
     * @param SiteSettings $siteSettings
     */
    public function __construct(SiteSettings $siteSettings)
    {
        $this->siteSettings = $siteSettings;
    }

    /**
     * Updates the observer with event data.
     *
     * @param mixed $eventData
     * @return void
     */
    public function update($eventData): void
    {
        // Type check to ensure $eventData is an array
        if (!is_array($eventData)) {
            echo "Invalid event data type. Expected array.\n";
            return;
        }

        if ($eventData['type'] === 'crawl_completed') {
            $this->savePageAsHtml();
        }
    }

    /**
     * Saves the homepage content as an HTML file.
     *
     * @return void
     */
    private function savePageAsHtml(): void
    {
        // Fetch the URL from site settings
        $urlToFetch = $this->siteSettings->getCrawlerUrl();

        // Retrieve homepage content
        $homepageContent = file_get_contents($urlToFetch);

        if ($homepageContent === false) {
            echo "Failed to retrieve homepage content.\n";
            return;
        }

        // Save the content as an HTML file
        $result = file_put_contents(__DIR__ . '/../../views/public/saved_page.html', $homepageContent);

        if ($result === false) {
            echo "Failed to save homepage as HTML.\n";
        } else {
            echo "Homepage saved as HTML successfully!\n";
        }
    }
}