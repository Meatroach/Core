<?php

namespace OpenTribes\Core\Silex\Request;


use OpenTribes\Core\Request\LoginRequest;
use Symfony\Component\HttpFoundation\Request;

class IndexRequest implements LoginRequest{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getUsername()
    {

      return  $this->request->get('username','');
    }

    public function getPassword()
    {
        return $this->request->get('password','');
    }

} 