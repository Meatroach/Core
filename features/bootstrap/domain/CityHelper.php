<?php

use OpenTribes\Core\Context\Player\CreateNewCity as CreateNewCityInteractor;
use OpenTribes\Core\Context\Player\ViewLocation as ViewLocationInteractor;
use OpenTribes\Core\Interactor\CreateCity as CreateCityInteractor;
use OpenTribes\Core\Interactor\ViewCities as ViewCitiesInteractor;
use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Request\CreateCity as CreateCityRequest;
use OpenTribes\Core\Request\CreateNewCity as CreateNewCityRequest;
use OpenTribes\Core\Request\ViewCities as ViewCitiesRequest;
use OpenTribes\Core\Request\ViewLocation as ViewLocationRequest;
use OpenTribes\Core\Response\CreateCity as CreateCityResponse;
use OpenTribes\Core\Response\CreateNewCity as CreateNewCityResponse;
use OpenTribes\Core\Response\ViewCities as ViewCitiesResponse;
use OpenTribes\Core\Response\ViewLocation as ViewLocationResponse;
use OpenTribes\Core\Service\LocationCalculator;
use PHPUnit_Framework_Assert as Test;

class CityHelper
{

    private $userRepository;
    private $cityRepository;
    private $mapTilesRepository;
    private $cityBuildingsRepository;
    /**
     * @var boolean
     */
    private $interactorResult;
    private $locationCalculator;
    /**
     * @var ViewLocationResponse
     */
    private $viewLocationResponse;
    private $buildingRepository;
    protected $x = 0;
    protected $y = 0;
    private $viewCitiesResponse;

    public function __construct(
        CityRepository $cityRepository,
        MapTilesRepository $mapTilesRepository,
        UserRepository $userRepository,
        LocationCalculator $locationCalculator,
        CityBuildingsRepository $cityBuildingsRepository,
        BuildingRepository $buildingRepository
    ) {
        $this->userRepository = $userRepository;
        $this->cityRepository = $cityRepository;
        $this->mapTilesRepository = $mapTilesRepository;
        $this->locationCalculator = $locationCalculator;
        $this->cityBuildingsRepository = $cityBuildingsRepository;
        $this->buildingRepository = $buildingRepository;
    }

    public function createDummyCity($name, $owner, $y, $x)
    {
        $cityId = $this->cityRepository->getUniqueId();
        $user = $this->userRepository->findOneByUsername($owner);
        if (!$user) {
            throw new Exception("Dummy city could not be created, user not found");
        }
        $city = $this->cityRepository->create($cityId, $name, $y, $x);
        $city->setOwner($user);
        $this->cityRepository->add($city);
    }

    public function createCityAsUser($y, $x, $username)
    {
        $request = new CreateCityRequest($y, $x, $username, $username . '\'s Village');
        $response = new CreateCityResponse;
        $interactor = new CreateCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository);

        $this->interactorResult = $interactor->process($request, $response);
    }

    public function assertCityCreated()
    {
        Test::assertTrue($this->interactorResult);
    }

    public function assertCityNotCreated()
    {

        Test::assertFalse($this->interactorResult);
    }

    public function assertCityIsInArea($minX, $maxX, $minY, $maxY)
    {
        Test::assertGreaterThanOrEqual((int)$minX, $this->x);
        Test::assertLessThanOrEqual((int)$maxX, $this->x);
        Test::assertGreaterThanOrEqual((int)$minY, $this->y);
        Test::assertLessThanOrEqual((int)$maxY, $this->y);
    }

    public function assertCityIsNotAtLocations(array $locations)
    {
        foreach ($locations as $location) {
            $x = $location[1];
            $y = $location[0];
            $expectedKey = sprintf('Y%d/X%d', $y, $x);
            $currentKey = sprintf('Y%d/X%d', $this->y, $this->x);
            Test::assertNotSame($currentKey, $expectedKey, sprintf("%s is not %s", $expectedKey, $currentKey));
        }
    }

    private function getDefaultCityName($username)
    {
        return sprintf("%s's City", $username);
    }

    public function selectLocation($direction, $username)
    {
        $request = new CreateNewCityRequest($username, $direction, $this->getDefaultCityName($username));
        $interactor = new CreateNewCityInteractor($this->cityRepository, $this->mapTilesRepository, $this->userRepository, $this->locationCalculator);
        $response = new CreateNewCityResponse;
        $interactor->process($request, $response);
        Test::assertNotNull($response->city);
        $this->x = $response->city->posX;
        $this->y = $response->city->posY;
    }

    public function selectPosition($y, $x, $username)
    {

        $request = new ViewLocationRequest($username, $y, $x);
        $interactor = new ViewLocationInteractor($this->cityRepository, $this->cityBuildingsRepository, $this->buildingRepository);
        $this->viewLocationResponse = new ViewLocationResponse;
        $this->interactorResult = $interactor->process($request, $this->viewLocationResponse);
    }

    public function assertCityHasBuilding($name, $level)
    {
        $buildings = $this->viewLocationResponse->buildings;
        $found = null;
        foreach ($buildings as $building) {
            if ($building->name === $name) {
                $found = $building;
                break;
            }
        }
        Test::assertNotNull($found);
        Test::assertSame($found->name, $name);
        Test::assertSame($found->level, (int)$level);
    }

    public function listUsersCities($username)
    {
        $request = new ViewCitiesRequest($username);
        $interactor = new ViewCitiesInteractor($this->userRepository, $this->cityRepository);
        $this->viewCitiesResponse = new ViewCitiesResponse();
        $this->interactorResult = $interactor->process($request, $this->viewCitiesResponse);
    }

    /**
     * @param integer $y
     * @param integer $x
     */
    public function assertCityExists($name, $owner, $y, $x)
    {
        $found = null;
        $cities = $this->viewCitiesResponse->cities;

        foreach ($cities as $city) {
            if ($city->name === $name) {
                $found = $city;
                break;
            }
        }

        Test::assertNotNull($found);
        Test::assertSame($found->name, $name);
        Test::assertSame($found->owner, $owner);
        Test::assertSame($found->posY, $y);
        Test::assertSame($found->posX, $x);
    }

    public function assertCity($name, $owner, $y, $x)
    {
        $city = $this->viewLocationResponse->city;
        Test::assertNotNull($city);
        Test::assertAttributeSame($name, 'name', $city);
        Test::assertAttributeSame($owner, 'owner', $city);
        Test::assertAttributeSame((int)$y, 'posY', $city);
        Test::assertAttributeSame((int)$x, 'posX', $city);
    }
}
