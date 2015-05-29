<?php
namespace OpenTribes\Core\Silex\Response;

use OpenTribes\Core\Silex\Response\SymfonyBaseResponse;
use Symfony\Component\HttpFoundation\Response;

class MustacheResponse extends Response{
    private $rawResponse;
    public function setResponse(SymfonyBaseResponse $response){
        $this->rawResponse = $response;
    }
} 