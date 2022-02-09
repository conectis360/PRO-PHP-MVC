<?php

namespace Framework\View\Engine;

class Phpengine implements Engine {

    protected string $path;
    protected ?string $layout;
    protected string $content;

    protected function extends(string $template): static {
        $this->layout = $template;
        return $this;
    }

    public function render(string $path, array $data = []): string {
        $this->path = $path;

        extract($data);

        ob_start();
        include($this->path);
        $contents = ob_get_contents();
        ob_end_clean();

        if($this->layout) {
            $__layout = $this->layout;
            
            $this->layout = null;
            $this->contents = $contents;
            $contentsWIthLayout = view($__layout, $data);

            return $contentsWIthLayout;
        }

        return $contents;
    }

    protected function escape(string $content): string {
        return htmlspecialchars($content, ENT_QUOTES);
    }

}