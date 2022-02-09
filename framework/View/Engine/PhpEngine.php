<?php

namespace Framework\View\Engine;

use Framework\View\Engine\HasManager;
use Framework\View\View;
use function view;

class Phpengine implements Engine {

    use HasManager;

    protected $layouts = [];


    public function render(View $view): string {
        extract($view->data);

        ob_start();
        include($view->path);
        $contents = ob_get_contents();
        ob_end_clean();

        if($layout = $this->layouts[$view->path] ?? null) {
            $contentsWithLayout = view($layout, array_merge(
                $view->data,
                ['contents' => $contents],
            ));

            return $contentsWithLayout;
        }

        return $contents;
    }

    public function __call(string $name, $values) {
        return $this->manager->useMacro($name, ...$values);
    }

    protected function extends(string $template): static {
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);
        $this->layouts[realpath($backtrace[0]['file'])] = $template;
        return $this;
    }

    protected function includes(string $template, $data = []):void {
        print view($template, $data);
    }
}