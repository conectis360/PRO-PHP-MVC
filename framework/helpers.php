<?php

use Framework\View;

function view(string $template, array $data = []): string {
    static $manager;

    if (!$manager) {
        $manager = new View\Manager();

        $manager->addPath(__DIR__ . '/../resources/views');

        $manager->addEngine('basic.php', new View\Engine\BasicEngine());
        $manager->addEngine('php', new View\Engine\Phpengine());
    }
    return $manager->render($template, $data);
}