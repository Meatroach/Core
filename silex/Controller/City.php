<?php

namespace OpenTribes\Core\Silex\Controller;

use Symfony\Component\HttpFoundation\Request;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Interactor\ViewCities as ViewCitiesInteractor;
use OpenTribes\Core\Request\ViewCities as ViewCitiesRequest;
use OpenTribes\Core\Response\ViewCities as ViewCitiesResponse;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City {

    private $cityRepository;
    private $userRepository;

    public function __construct(UserRepository $userRepository, CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
        $this->userRepository = $userRepository;
    }

    public function listAction(Request $httpRequest) {
        $username = $httpRequest->get('username');
        $request    = new ViewCitiesRequest($username);
        $interactor = new ViewCitiesInteractor($this->userRepository, $this->cityRepository);
        $response = new ViewCitiesResponse;
        $response->failed    = !$interactor->process($request, $response);
        return $response;
    }

}
