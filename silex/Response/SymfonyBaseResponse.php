<?php

namespace OpenTribes\Core\Silex\Response;

use Symfony\Component\HttpFoundation\Request;

abstract class SymfonyBaseResponse
{
    public $baseUrl = '/';
    public $isAjaxRequest = false;


    public function setRequest(Request $request){

        $this->isAjaxRequest = $request->isXmlHttpRequest();
    }


} 