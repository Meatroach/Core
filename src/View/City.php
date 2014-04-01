<?php

namespace OpenTribes\Core\View;
use OpenTribes\Core\Entity\City as CityEntity;
/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City {
    public $id;
    public $name;
    public $x;
    public $y;
    public $owner;
    public function __construct(CityEntity $city) {
        $this->id = $city->getId();
        $this->name = $city->getName();
        $this->x = $city->getX();
        $this->y = $city->getY();
        $this->owner = $city->getOwner()->getUsername();
    }
}
