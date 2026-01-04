<?php

namespace Phro\TheRig;

class Dispatcher {

    private \GuzzleHttp\Psr7\Response $response;

    public function __construct(\GuzzleHttp\Psr7\Response $response) {
        $this->response = $response;
    }

    public function sendResponse(): void {
        http_response_code($this->response->getStatusCode());
        echo $this->response->getBody();
    }

}