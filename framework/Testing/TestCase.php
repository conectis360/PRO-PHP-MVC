<?php

namespace Framework\Testing;

use Closure;
use Exception;
use PHPUnit\Framework\TestCase as BaseTestCase;
use Throwable;

class TestCase extends BaseTestCase {
    protected function assertExceptionThrown(Closure $risky, string $exceptionType) {
        $result = null;
        $exception = null;

        try {
            $result = $risky();
            $this->fail('exception was not thrown');
        }
        catch (Throwable $e){
            $actualType = $e::class;

            if($actualType !== $exceptionType) {
                $this->fail("exception was {$actualType}, but excepted {$exceptionType}");
            }
            $exception = $e;
        }

        return [$exception, $result];
    }
}