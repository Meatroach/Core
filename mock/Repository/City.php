<?php

namespace OpenTribes\Core\Mock\Repository;

use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\City as CityRepository;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City implements CityRepository {

    /**
     * @var CityEntity[] 
     */
    private $cities = array();

    /**
     * {@inheritDoc}
     */
    public function add(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }

    /**
     * {@inheritDoc}
     */
    public function create($id, $name,  $y, $x) {
        return new CityEntity($id, $name, $y, $x);
    }

    /**
     * {@inheritDoc}
     */
    public function getUniqueId() {
        $countCities = count($this->cities);
        $countCities++;
        return $countCities;
    }

    /**
     * {@inheritDoc}
     */
    public function cityExistsAt($y, $x) {

        return (bool) $this->findByLocation($y, $x);
    }

    /**
     * {@inheritDoc}
     */
    public function findAllByOwner(UserEntity $owner) {
        $found = array();
        foreach ($this->cities as $city) {
            if ($city->getOwner() === $owner) {
                $found[] = $city;
            }
        }
        return $found;
    }

    /**
     * {@inheritDoc}
     */
    public function findByLocation($y, $x) {
        $y = (int) $y;
        $x = (int) $x;
        foreach ($this->cities as $city) {

            if ($city->getX() === $x && $city->getY() === $y) {

                return $city;
            }
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function replace(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }

    /**
     * {@inheritDoc}
     */
    public function countAll() {
        return count($this->cities);
    }

    /**
     * {@inheritDoc}
     */
    public function sync() {
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function delete(CityEntity $city) {
        unset($this->cities[$city->getId()]);
    }

    /**
     * {@inheritDoc}
     */
    public function flush() {
        $this->cities = array();
    }

    /**
     * {@inheritDoc}
     */
    public function findSelectedByUsername($username) {
        foreach ($this->cities as $city) {
            if ($city->getOwner()->getUsername() === $username && $city->isSelected()) {
                return $city;
            }
        }
    }
    public function findAllInArea(array $area) {
        ;
    }
    public function getLastCreatedCity() {

        $lastCity =  end($this->cities);

        return $lastCity ;
    }
}
