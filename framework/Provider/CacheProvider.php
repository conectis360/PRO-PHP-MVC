<?php

namespace Framework\Provider;

use Framework\Cache\Factory;
use Framework\Cache\Driver\Driver;

class CacheProvider{
    public function bind(App $app): void {
        $app->bind('cache', function($app){
            $factory = new Factory();
            $this->addMemoryDriver($factory);

            $config = config('cache');

            return $factory->connect($config[$config['default']]);
        });
    }
}