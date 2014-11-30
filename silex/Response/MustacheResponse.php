<?php

namespace OpenTribes\Core\Silex\Response;


use Symfony\Component\HttpFoundation\Response;

class MustacheResponse extends Response{
    private $rawResponse;
    public function setResponse(\OpenTribes\Core\Response\Response $response){
        $this->rawResponse = $response;
    }

} 