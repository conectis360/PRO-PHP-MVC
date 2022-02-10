<?php

use App\Http\Controllers\Products\ListProductsController;
use APP\Http\Controllers\ShowHomeController;
use Framework\Routing\Router;

return function(Router $router) {
    $router->add(
        'GET', '/',
        [ShowHomeController::class, 'handle']
    );

    $router->add(
        'GET', '/old-home',
        fn() => $router->redirect('/'),
    );

    $router->add(
        'GET', '/has-server-error',
        fn() => throw new Exception(),
    );

    $router->add(
        'GET', '/has-validation-error',
        fn() => $router->dispatchNotAllowed()
    );

    $router->errorHandler(
        404, fn() => 'whoops!'
    );

    $router->add(
        'GET', '/products/view/{product}',
        function () use ($router) {
            $parameters = $router->current()->parameters();

            return view('products/view', [
                'product' => $parameters['product'],
                'scary' => '<script>alert("hello")</script>',
            ]);
        },
    );

    $router->add(
        'GET', '/products/{page?}',
        function () use ($router) {
            $parameters = $router->current()->parameters();
            $parameters['page'] ??= 1;

            $next = $router->route(
                'product-list', ['page' => $parameters['page'] + 1]
            );

            return view('products/list', [
                'parameters' => $parameters,
                'next' => $next,
            ]);
        },
    )->name('product-list');

    $router->add(
        'GET', '/services/view/{service?}',
        function () use ($router) {
            $parameters = $router->current()->parameters();

            if (empty($parameters['service'])) {
                return 'all services';  
            }
        
            return "service is {$parameters['service']}";  
        },
    );

    $router->add(
        'GET', '/products/{page?}',
        [new ListProductsController($router), 'handle'],
    )->name('list-products');
    
};
