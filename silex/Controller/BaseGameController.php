<?php

namespace OpenTribes\Core\Silex\Controller;


use OpenTribes\Core\Repository\CityRepository;
use OpenTribes\Core\Silex\Repository;
use Silex\Application;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BaseGameController extends AuthenticateController{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    public function __construct(Repository\WritableRepository $userRepository,CityRepository $cityRepository)
    {
        parent::__construct($userRepository);
        $this->cityRepository = $cityRepository;
    }

    public function before(Request $httpRequest){

        $result = parent::before($httpRequest);
        if($result instanceof Response){
            return $result;
        }
        $session = $httpRequest->getSession();
        $userHasCities = $this->cityRepository->countUserCities($session->get('username')) > 0;
        if(!$userHasCities && $httpRequest->getRequestUri() !== '/city/create'){
            return new RedirectResponse('/city/create');
        }
        return '';
    }
}