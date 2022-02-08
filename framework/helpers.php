<?php

use Framework\View;

if(!function_exists('view')){
    function view(string $template, array $data = []): string {
        if($manager){
            $manager = new View\Manager();

            $manager->addPath(__DIR__ . '/../resources/views');
            $manager->addEngine('basic.php', new View\Engine\BasicEngine());
        }
        
        return $manager->render($template, $data);
    }
}