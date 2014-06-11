<?php

use Behat\Mink\Element\DocumentElement;
use Behat\Mink\Mink;
use OpenTribes\Core\Repository\Building as BuildingRepository;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;
use OpenTribes\Core\Repository\MapTiles as MapTilesRepository;
use OpenTribes\Core\Repository\User as UserRepository;
use OpenTribes\Core\Service\LocationCalculator;
use PHPUnit_Framework_Assert as Test;

/**
 * Description of CityHelper
 *
 * @author BlackScorp<witalimik@web.de>
 */
class SilexCityHelper extends CityHelper
{

    private $mink;
    private $sessionName;

    /**
     * @var DocumentElement
     */
    private $page;


    public function __construct(
        Mink $mink,
        CityRepository $cityRepository,
        MapTilesRepository $mapTilesRepository,
        UserRepository $userRepository,
        LocationCalculator $locationCalculator,
        CityBuildingsRepository $cityBuildingsRepository,
        BuildingRepository $buildingRepository
    ) {
        parent::__construct(
            $cityRepository,
            $mapTilesRepository,
            $userRepository,
            $locationCalculator,
            $cityBuildingsRepository,
            $buildingRepository
        );
        $this->mink        = $mink;
        $this->sessionName = $this->mink->getDefaultSessionName();
    }

    private function loadPage()
    {
        $this->page = $this->mink->getSession($this->sessionName)->getPage();
    }

    public function selectLocation($direction, $username)
    {
        $this->loadPage();

        $this->mink->getSession()->setCookie('username', $username);
        $this->page->selectFieldOption('direction', $direction);
        $this->page->pressButton('select');
    }

    public function assertCityIsInArea($minX, $maxX, $minY, $maxY)
    {
        $this->loadPage();
        $spanX = $this->page->find('css', 'span.x');
        $spanY = $this->page->find('css', 'span.y');

        $this->mink->assertSession()->statusCodeEquals(200);
        Test::assertNotNull($spanY, 'span class="y" not found');
        Test::assertNotNull($spanX, 'span class="x" not found');
        $this->x = (int)$spanX->getText();
        $this->y = (int)$spanY->getText();

        Test::assertGreaterThanOrEqual((int)$minX, $this->x);
        Test::assertLessThanOrEqual((int)$maxX, $this->x);
        Test::assertGreaterThanOrEqual((int)$minY, $this->y);
        Test::assertLessThanOrEqual((int)$maxY, $this->y);
    }

    public function assertCityIsNotAtLocations(array $locations)
    {

        foreach ($locations as $location) {
            $x           = $location[1];
            $y           = $location[0];
            $expectedKey = sprintf('Y%d/X%d', $y, $x);
            $currentKey  = sprintf('Y%d/X%d', $this->y, $this->x);
            Test::assertNotSame($currentKey, $expectedKey, sprintf("%s is not %s", $expectedKey, $currentKey));
        }
    }

    /**
     * @param integer $y
     * @param integer $x
     */
    public function assertCityExists($name, $owner, $y, $x)
    {
        $this->loadPage();
        $this->page->hasContent($name);
        $this->page->hasContent($owner);
        $this->page->hasContent($y);
        $this->page->hasContent($x);
    }

    public function assertCityHasBuilding($name, $level)
    {
        throw new \Behat\Behat\Exception\PendingException;
    }

    public function assertCity($name, $owner, $y, $x)
    {
        throw new \Behat\Behat\Exception\PendingException;
    }
}
