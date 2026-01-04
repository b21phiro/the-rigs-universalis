<?php

namespace Phro\TheRig;

class View {

    public function html(): string {
        ob_start();
        include __DIR__ . '/views/index.php';
        return ob_get_clean();
    }

}