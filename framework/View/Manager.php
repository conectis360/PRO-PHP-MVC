<?php

namespace Framework\View;

use Exception;
use Framework\View\Engine\Engine;

class Manager {
    protected array $paths = [];
    protected array $engines = [];

    public function addPath(string $path): static {
        array_push($this->paths, $path);
        return $this;
    }

    public function addEngine(string $extensions, Engine $engine): static {
        $this->engines[$extensions] = $engine;
        return $this;
    }

    public function render(string $template, array $data = []): string {
        //render the template...
    }
}
