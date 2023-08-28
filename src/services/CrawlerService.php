<?php

namespace App\Services;

/**
 * Class CrawlerService
 *
 * Service class responsible for web crawling functionalities.
 */
class CrawlerService
{
    /**
     * Fetch content from a given URL.
     *
     * @param string $url The URL to fetch content from.
     * @return string The content of the URL.
     */
    public function fetchContent(string $url): string
    {
        return file_get_contents($url);
    }

    /**
     * Extract links from the given HTML content.
     *
     * @param string $content The HTML content.
     * @return array An array of extracted links.
     */
    public function extractLinks(string $content): array
    {
        $dom = new \DOMDocument();
        @$dom->loadHTML($content);
        $links = [];

        foreach ($dom->getElementsByTagName('a') as $tag) {
            $links[] = $tag->getAttribute('href');
        }

        return $links;
    }

    /**
     * Generate a sitemap from the given list of links.
     *
     * @param array $links An array of links.
     * @return void
     */
    public function generateSitemap(array $links): void
    {
        $sitemapContent = "<ul>";

        foreach ($links as $link) {
            $sitemapContent .= "<li><a href='{$link}'>{$link}</a></li>";
        }

        $sitemapContent .= "</ul>";

        try {
            $writeStatus = file_put_contents(__DIR__ . '/../../sitemap.html', $sitemapContent);

            if (false === $writeStatus) {
                echo "Failed to write sitemap!<br>";
            } else {
                echo "File written successfully!<br>";
            }
        } catch (\Exception $e) {
            echo "Failed to write to disk: {$e->getMessage()}<br>";
        }
    }
}