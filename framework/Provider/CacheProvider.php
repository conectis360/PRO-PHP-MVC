<?php

namespace Framework\Provider;

use Framework\Cache\Factory;
use Framework\Cache\Driver\Driver;

class CacheProvider
{
    private function addMemoryDriver($factory): void
    {
        $factory->addDriver('memory', function ($config) {
            return new MemoryDriver($config);
        });
    }
    public function bind(App $app): void
    {
        $app->bind('cache', function ($app) {
            $factory = new Factory();
            $this->addFileDriver($factory);
            $this->addMemcacheDriver($factory);
            $this->addMemoryDriver($factory);
            $config = config('cache');
            return $factory->connect($config[$config['default']]);
        });
    }
    private function addFileDriver($factory): void
    {
        $factory->addDriver('file', function ($config) {
            return new FileDriver($config);
        });
    }
    private function addMemcacheDriver($factory): void
    {
        $factory->addDriver('memcache', function ($config) {
            return new MemcacheDriver($config);
        });
    }
    private function addMemoryDriver($factory): void
    {
        $factory->addDriver('memory', function ($config) {
            return new MemoryDriver($config);
        });
    }
}
