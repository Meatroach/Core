<?php

namespace OpenTribes\Core\Silex\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController {
    public function before(Request $httpRequest){
        $session = $httpRequest->getSession();
        if(!$session->get('username')){
            return new RedirectResponse('/');
        }
        return '';
    }
}