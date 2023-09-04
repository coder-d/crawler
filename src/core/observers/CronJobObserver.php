<?php

namespace App\Core\Observers;

use App\Core\Interfaces\ObserverInterface;
use App\Core\SiteSettings;

/**
 * Observer for handling cron job related tasks.
 */
class CronJobObserver implements ObserverInterface
{
    /**
     * Path to the script directory.
     *
     * @var string
     */
    private $scriptPath;

    /**
     * Web user obtained from SiteSettings.
     *
     * @var string
     */
    private $webUser;

    /**
     * CronJobObserver constructor.
     *
     * @param string       $scriptPath   Path to the script.
     * @param SiteSettings $siteSettings Instance of SiteSettings.
     */
    public function __construct(string $scriptPath, SiteSettings $siteSettings)
    {
        $this->scriptPath = $scriptPath;
        $this->webUser = $siteSettings->getWebUser();
    }

    /**
     * Update method which is triggered on an event.
     *
     * @param array $eventData Data related to the event.
     *
     * @return void
     */
    public function update($eventData): void
    {
        if ($eventData['type'] !== 'crawl_completed') {
            return;
        }

        if (!file_exists($this->scriptPath)) {
            echo 'Script path does not exist: ' . $this->scriptPath;
            return;
        }

        $filePath = $this->scriptPath . '/runCrawl.sh';

        if (!file_exists($filePath)) {
            $shellScript = "#!/bin/bash\nsudo -u " . $this->webUser . " php " . $this->scriptPath . "/triggerWebCrawl.php";

            if (file_put_contents($filePath, $shellScript) === false) {
                echo 'Failed to create shell script';
                return;
            }

            if (!chmod($filePath, 0755)) {
                echo 'Failed to make shell script executable';
                return;
            }

            // Create a temporary file for crontab operations
            $tempFile = tempnam(sys_get_temp_dir(), 'cron');

            // Gather the current crontab and append the new task
            exec('crontab -l > ' . $tempFile);
            file_put_contents($tempFile, '0 * * * * ' . $filePath . PHP_EOL, FILE_APPEND);

            // Import the modified crontab
            $output = null;
            $resultCode = 0;
            exec('crontab ' . $tempFile . ' 2>&1', $output, $resultCode);
            
            // Clean up by deleting the temporary file
            unlink($tempFile);

            if ($resultCode !== 0) {
                echo 'Failed to add cron job. Error code: ' . $resultCode .'<br/>';
                return;
            }

            echo 'Shell script and cron job created successfully!<br/>';
        }
    }
}