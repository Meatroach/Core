<?php

namespace OpenTribes\Core\Silex\Controller;

use OpenTribes\Core\Context\Player\CreateNewCity as CreateNewCityInteractor;
use OpenTribes\Core\Interactor\ViewCities as ViewCitiesInteractor;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Request\ViewCities as ViewCitiesRequest;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Response\ViewCities as ViewCitiesResponse;
use OpenTribes\Core\Service\LocationCalculator;
use Symfony\Component\HttpFoundation\Request;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City {

    private $cityRepository;
    private $userRepository;
    private $mapTilesRepository;
    private $locationCalculator;

    public function __construct(UserRepository $userRepository, CityRepository $cityRepository, MapTilesRepository $mapTilesRepository, LocationCalculator $locationCalculator) {
        $this->cityRepository     = $cityRepository;
        $this->userRepository     = $userRepository;
        $this->mapTilesRepository = $mapTilesRepository;
        $this->locationCalculator = $locationCalculator;
    }

    public function listAction(Request $httpRequest) {
        $defaultUsername = $httpRequest->getSession()->get('username');
        $username        = $httpRequest->get('username', $defaultUsername);

        $request           = new ViewCitiesRequest($username);
        $interactor        = new ViewCitiesInteractor($this->userRepository, $this->cityRepository);
        $response          = new ViewCitiesResponse;
        $response->proceed = true;
        $response->failed  = !$interactor->process($request, $response);
        var_dump($response);
        return $response;
    }

    public function newAction(Request $httpRequest) {
        $username        = $httpRequest->getSession()->get('username');
        $direction       = $httpRequest->get('direction', 'any');
        //Has to be in config
        $defaultCityName = sprintf('%s\'s City', $username);
        $directions      = array(
            array('name' => 'any', 'selected' => $direction === 'any'),
            array('name' => 'north', 'selected' => $direction === 'north'),
            array('name' => 'east', 'selected' => $direction === 'east'),
            array('name' => 'south', 'selected' => $direction === 'south'),
            array('name' => 'west', 'selected' => $direction === 'west'),
        );

        $request    = new CreateNewCityRequest($username, $direction, $defaultCityName);
        $interactor = new CreateNewCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository, $this->locationCalculator);
        $response   = new CreateNewCityResponse;
        if ($httpRequest->getMethod() === 'POST') {
            $response->proceed = true;
            $response->failed  = !$interactor->process($request, $response);
        }

        $response->directions = $directions;
        return $response;
    }

    public function after() {
        $this->cityRepository->sync();
    }

}
