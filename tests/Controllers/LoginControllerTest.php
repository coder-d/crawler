<?php

use App\Controllers\LoginController;
use App\Core\SiteSettings;
use PHPUnit\Framework\TestCase;

class LoginControllerTest extends TestCase {

    private $controller;
    private $settingsMock;

    protected function setUp(): void {
        $this->settingsMock = $this->createMock(SiteSettings::class);
        $this->controller = $this->getMockBuilder(LoginController::class)
                                  ->setConstructorArgs([$this->settingsMock])
                                  ->onlyMethods(['redirectTo'])
                                  ->getMock();
    }

    public function testShowLoginFormIfNotLoggedIn(): void {
        $_SESSION['admin_logged_in'] = false;
        ob_start();
        $this->controller->showLoginForm();
        $output = ob_get_clean();
        $this->assertStringContainsString('<h1>Admin Login</h1>', $output);
    }

    // public function testHandleSuccessfulLogin(): void {
    //     $_SESSION['admin_logged_in'] = false;
    //     $_SERVER["REQUEST_METHOD"] = "POST";
    //     $_POST['username'] = 'admin';
    //     $_POST['password'] = 'password';

    //     $this->controller->expects($this->once())
    //                      ->method('redirectTo')
    //                      ->with($this->equalTo('views/admin/dashboard'));

    //     $this->controller->login();
    // }

    // public function testHandleFailedLogin(): void {
    //     $_SESSION['admin_logged_in'] = false;
    //     $_SERVER["REQUEST_METHOD"] = "POST";
    //     $_POST['username'] = 'wrong';
    //     $_POST['password'] = 'wrong';

    //     $this->controller->expects($this->once())
    //                      ->method('redirectTo')
    //                      ->with($this->equalTo('views/login?error=1'));

    //     $this->controller->login();
        
    //     $this->assertFalse($_SESSION['admin_logged_in']);
    // }

    protected function tearDown(): void {
        $_SESSION = [];
        $_SERVER = [];
        $_POST = [];
    }
}