<?php

namespace OpenTribes\Core\View;

use OpenTribes\Core\Entity\City as CityEntity;

/**
 * Description of City
 *
 * @author BlackScorp<witalimik@web.de>
 */
class City
{
    public $cityId;
    public $name;
    public $posX;
    public $posY;
    public $width;
    public $height;
    public $top;
    public $left;
    public $level;
    public $layerZ;
    public $owner;

    public function __construct(CityEntity $city)
    {
        $this->cityId = $city->getCityId();
        $this->name = $city->getName();
        $this->posX = $city->getPosX();
        $this->posY = $city->getPosY();
        $this->owner = $city->getOwner()->getUsername();
    }
}
