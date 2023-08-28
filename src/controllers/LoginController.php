<?php

namespace App\Controllers;

use App\Core\SiteSettings;

class LoginController
{
    /**
     * Site settings instance.
     *
     * @var SiteSettings
     */
    private $siteSettings;

    /**
     * Constructor to initialize the Site settings.
     *
     * @param SiteSettings $siteSettings Site settings object.
     */
    public function __construct(SiteSettings $siteSettings)
    {
        $this->siteSettings = $siteSettings;
    }

    /**
     * Show the login form.
     *
     * @return void
     */
    public function showLoginForm(): void
    {
        if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            $this->redirectTo('views/admin/dashboard');
            exit;
        }

        $baseUrl = $this->siteSettings->getBaseUrl();
        require_once __DIR__ . '/../views/login.php';
    }

    /**
     * Perform login operation.
     *
     * @return void
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['username'] === 'admin' && $_POST['password'] === 'password') {
                $_SESSION['admin_logged_in'] = true;
                $this->redirectTo('views/admin/dashboard');
                exit;
            } else {
                $this->redirectTo('views/login?error=1');
                exit;
            }
        }
    }

    /**
     * Redirect to the given URL.
     *
     * @param string $url URL to redirect to.
     * @return void
     */
    protected function redirectTo(string $url): void
    {
        header('Location: ' . $this->siteSettings->getBaseUrl() . $url);
        exit;
    }
}