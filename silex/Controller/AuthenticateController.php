<?php

namespace OpenTribes\Core\Silex\Controller;



use OpenTribes\Core\Silex\Repository\WritableRepository;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

class AuthenticateController{
    /**
     * @var WritableRepository
     */
    protected $useRepository;
    public function __construct(WritableRepository $userRepository){
        $this->useRepository = $userRepository;
    }
    public function before(Request $httpRequest){

        $session = $httpRequest->getSession();

        if(!$session->get('username')){
            return new RedirectResponse('/');
        }
        return '';
    }
    public function after(){
        $this->useRepository->sync();
    }
}