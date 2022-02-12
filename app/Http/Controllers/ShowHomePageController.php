<?php

namespace App\Http\Controllers;

class ShowHomePageController
{
    public function handle()
    {
        $factory = new Factory();

        $factory->addConnector('mysql', function($config) {
            return new MysqlConnection($config);
        });

        $connection = $factory->connect([
            'type' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'pro-php-mvc',
            'username' => 'root',
            'password' => '',
        ]);

        $product = $connection->query()->select()->from('products')->first();
        
        return view('home', ['number' => 42]);
    }
}
