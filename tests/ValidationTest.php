<?php
require __DIR__ . '/../vendor/autoload.php';

session_start();

use Framework\Validation\Manager;
use Framework\Validation\EmailRule;
use Framework\Validation\ValidationException;

class ValidationTest {
    protected Manager $manager;

    public function setUp()
    {
        $this->manager = new Manager();
        $this->manager->addRule('email', new EmailRule());
    }

    public function testInvalidEmailValuesFail() {
        $this->setUp();

        $expected = ['email' => ['email should be an email']];

        [$exception] = $this->assertExceptionThrown(fn() => $this->manager->validate(['email' => 'foo'], 
        ['email' => ['email']]), ValidationException::class,);

        $this->assertEquals($expected, $exception->getErrors());
    }

    public function testValidEmailValuesPass() {
        $this->setUp();
        try {
            $this->manager->validate(['email' => 'foo@bar.com'], ['email' => ['email']]);
        }
        catch(Throwable $e) {
            throw new Exception('validation did failed');
            return;
        }
    }
}

$test = new ValidationTest();
$test->testInvalidEmailValuesFail();
$test->testValidEmailValuesPass();

print 'All tests passed' . PHP_EOL;