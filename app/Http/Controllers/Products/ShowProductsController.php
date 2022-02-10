<?php

namespace App\Http\Controllers\Products;
use Framework\Routing\Router;

class ListProductsController {

    public function __construct(Router $router)
    {
        $this->router = $router;
    }

    public function handle() {
        $parameters = $router->current()->parameters();
        $parameters['page'] ??= 1;
        $next = $router->route(
            'list-products', ['page' => $parameters['page'] + 1]
        );

        return view('products/list', [
            'parameters' => $parameters,
            'next' => $next,
        ]);

    }
}