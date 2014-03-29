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

    public function add(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }

    public function create($id, $name, UserEntity $owner, $y, $x) {
        return new CityEntity($id, $name, $owner, $y, $x);
    }

    public function getUniqueId() {
        $countCities = count($this->cities);
        $countCities++;
        return $countCities;
    }

    public function cityExistsAt($y, $x) {

        return (bool) $this->findByLocation($y, $x);
    }
    public function findAllByOwner(UserEntity $owner){
        $found = array();
        foreach($this->cities as $city){
            if($city->getOwner() === $owner){
                $found[]=$city;
            }
        }
        return $found;
    }

    public function findByLocation($y, $x) {
        $y = (int)$y;
        $x = (int) $x;
        foreach ($this->cities as $city) {
           
            if ($city->getX() === $x && $city->getY() === $y) {
               
                return $city;
            }
        }
        return null;
    }
    public function replace(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }
    public function countAll() {
        return count($this->cities);
    }
}
