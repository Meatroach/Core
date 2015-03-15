<?php

namespace OpenTribes\Core\Silex\Response;


use Symfony\Component\HttpFoundation\Response;

class MustacheResponse extends Response{
    private $rawResponse;
    public function setResponse(SFBaseResponse $response){
        $this->rawResponse = $response;
    }

    /**
     * @return mixed
     */
    public function getRawResponse()
    {
        return $this->rawResponse;
    }

} 