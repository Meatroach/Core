<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Repository\City as CityRepository;
use OpenTribes\Core\Repository\CityBuildings as CityBuildingsRepository;

/**
 * Description of CityBuildings
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CityBuildings implements CityBuildingsRepository
{

    private $city;
    private $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * {@inheritDoc}
     */
    public function replace(CityEntity $city)
    {
        $this->cityRepository->replace($city);
    }

    /**
     * {@inheritDoc}
     */
    public function findByLocation($y, $x)
    {
        $this->city = $this->cityRepository->findByLocation($y, $x);
        return $this->city;
    }

    /**
     * {@inheritDoc}
     */
    public function sync()
    {
        ;
    }

}
