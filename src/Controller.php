<?php

namespace Phro\TheRig;
class Controller {

    private View $view;

    public function __construct(View $view) {
        $this->view = $view;
    }

    public function index(): \GuzzleHttp\Psr7\Response {
        $body = $this->view->html();
        return new \GuzzleHttp\Psr7\Response(200, [], $body);
    }

}