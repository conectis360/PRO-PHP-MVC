<?php

namespace App\Http\Controllers\Products;

class ListProductsController {
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