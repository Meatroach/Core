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
    public $width;
    public $height;
    public $top;
    public $left;
    public $level;
    public $z;
    public $owner;
    public function __construct(CityEntity $city) {
        $this->id = $city->getId();
        $this->name = $city->getName();
        $this->x = $city->getX();
        $this->y = $city->getY();
        if($city->getOwner()){
            $this->owner = $city->getOwner()->getUsername();
        }

    }
}
