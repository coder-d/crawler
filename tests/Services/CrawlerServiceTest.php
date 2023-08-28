<?php

use App\Services\CrawlerService;
use App\Core\SiteSettings;
use PHPUnit\Framework\TestCase;

class CrawlerServiceTest extends TestCase {

    private $crawlerService;
    private $siteSettings;

    protected function setUp(): void {
        $this->crawlerService = new CrawlerService();
        
        // Create an actual instance of SiteSettings to get the real base URL
        $realSiteSettings = new SiteSettings();
        $dynamicBaseUrl = $realSiteSettings->getBaseUrl();
    
        // Mock SiteSettings
        $this->siteSettings = $this->createMock(SiteSettings::class);
        $this->siteSettings->method('getBaseUrl')->willReturn($dynamicBaseUrl);
    }    

    /**
     * @dataProvider domainProvider
     */
    public function testFetchContent($domain) {
        $url = $this->siteSettings->getBaseUrl() . "$domain";
    
        // Mock the response here
        $mockedContent = "<html><head><title>$domain</title></head><body>$domain</body></html>";
    
        // Mock the file_get_contents method in CrawlerService
        $mock = $this->createPartialMock(CrawlerService::class, ['fetchContent']);
        $mock->expects($this->once())
             ->method('fetchContent')
             ->will($this->returnValue($mockedContent));
    
        $this->assertEquals($mockedContent, $mock->fetchContent($url));
    }

    /**
     * @dataProvider domainProvider
     */
    public function testExtractLinks($domain) {
        $htmlContent = "<a href='{$this->siteSettings->getBaseUrl()}$domain'>$domain</a><a href='{$this->siteSettings->getBaseUrl()}test/$domain'>Test</a>";
        $expectedLinks = [$this->siteSettings->getBaseUrl() . $domain, $this->siteSettings->getBaseUrl() . "test/$domain"];
        $this->assertEquals($expectedLinks, $this->crawlerService->extractLinks($htmlContent));
    }

    public function domainProvider() {
        return [
            ['views/login']
        ];
    }

    protected function tearDown(): void {
        $this->crawlerService = null;
    }
}