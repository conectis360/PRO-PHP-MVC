<?php

use Framework\App;

class RoutingTest extends Framework\Testing\TestCase {
    protected App $app;

    public function setUp(): void {
        parent::setUp();

        $this->app = App::getInstance();
        $this->app->bind('paths.base', fn() => __DIR__ . '/../');
    }

    public function testHomePageIsShown() {
        $_SERVER['REQUEST_METHOD'] = 'GET';
        $_SERVER['REQUEST_URI'] = '/';

        ob_start();
        $this->app->run();
        $html = ob_get_contents();
        ob_end_clean();

        $expected = 'Take a trip on a rocket ship';

        $this->assertStringContainsString($expected, $html);
    }

    public function testRegistrationErrorsAreShown() {
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_SERVER['REQUEST_URI'] = '/register';
        $_SERVER['HTTP_REFERER'] = '/register';

        $_POST['email'] = 'foo';
        $_POST['csrf'] = csrf();

        $expected = 'email should be an email';
        $this->assertStringContainsString($expected, $this->app->run());
    }
}