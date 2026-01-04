<?php

namespace Phro\TheRig;

class Route {

    public string $method;
    public string $path;
    public string $action;

    public function __construct(string $method, string $path, string $action) {
        $this->method = $method;
        $this->path = $path;
        $this->action = $action;
    }

}
