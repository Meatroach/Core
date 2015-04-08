<?php

namespace OpenTribes\Core\Silex\Controller;


use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthenticateController {
    public function before(){
        return new RedirectResponse('/');
    }
}