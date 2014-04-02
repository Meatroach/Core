<?php

namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use OpenTribes\Core\Entity\City as CityEntity;
use OpenTribes\Core\Entity\User as UserEntity;
use OpenTribes\Core\Repository\City as CityInterface;

/**
 * Description of DBALCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class DBALCity implements CityInterface {

    private $cities = array();
    private $db;

    public function __construct(Connection $db) {
        $this->db = $db;
    }

    public function add(CityEntity $city) {
        $this->cities[$city->getId()] = $city;
    }

    public function cityExistsAt($y, $x) {
        $result = $this->db->prepare("SELECT 1 FROM cities WHERE y = :y AND x = :x ");
        $result->execute(array(
            ':y' => $y,
            ':x' => $x
        ));
       return (bool) $result->fetchColumn();
    }

    public function create($id, $name, UserEntity $owner, $y, $x) {
        return new CityEntity($id, $name, $owner, $y, $x);
    }

    public function findAllByOwner(UserEntity $owner) {
        
    }

    public function findByLocation($y, $x) {
        
    }

    public function getUniqueId() {
        
    }

    public function replace(CityEntity $city) {
        
    }

    public function countAll() {
        ;
    }

    public function sync() {
        ;
    }

}
