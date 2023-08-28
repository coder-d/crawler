<?php

namespace App\Core\Observers;

use App\Core\Interfaces\ObserverInterface;
use App\Core\Interfaces\SubjectInterface;
use App\Services\CrawlerService;
use App\Core\SiteSettings;

/**
 * Crawl Manager
 *
 * Class responsible for managing crawling operations and observer notifications.
 */
class CrawlManager implements SubjectInterface
{
    /**
     * @var array<ObserverInterface> Array of observers.
     */
    private $observers = [];

    /**
     * @var CrawlerService The service responsible for fetching and extracting links.
     */
    private $service;

    /**
     * @var SiteSettings The site settings to get crawler URL.
     */
    private $siteSettings;

    /**
     * Constructor.
     *
     * @param CrawlerService $service The CrawlerService instance.
     * @param SiteSettings $siteSettings The SiteSettings instance.
     */
    public function __construct(CrawlerService $service, SiteSettings $siteSettings)
    {
        $this->service = $service;
        $this->siteSettings = $siteSettings;
    }
    /**
     * Perform the crawl operation.
     *
     * @return array The extracted links.
     */
    public function crawl(): array
    {
        $urlToCrawl = $this->siteSettings->getCrawlerUrl();
        $homepageContent = $this->service->fetchContent($urlToCrawl);
        $links = $this->service->extractLinks($homepageContent);

        $eventData = [
            'type' => 'crawl_completed',
            'data' => $links,
        ];
        // Notify observers before generating the sitemap
        $this->notifyObservers($eventData);

        // Generate the sitemap after observer has been notified (and old sitemap deleted)
        $this->service->generateSitemap($links);

        return $links;
    }
    /**
     * Add an observer.
     *
     * @param ObserverInterface $observer The observer instance.
     * @return void
     */
    public function addObserver(ObserverInterface $observer): void
    {
        $this->observers[] = $observer;
    }

    /**
     * Remove an observer.
     *
     * @param ObserverInterface $observer The observer instance.
     * @return void
     */
    public function removeObserver(ObserverInterface $observer): void
    {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    /**
     * Notify all registered observers.
     *
     * @param mixed $eventData Data related to the event.
     * @return void
     */
    public function notifyObservers($eventData): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($eventData);
        }
    }
}