<?php

namespace OpenTribes\Core\View;
use OpenTribes\Core\Entity\Building as BuildingEntity;
/**
 * Description of CityBuilding
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CityBuilding {
    public $level;
    public $name;
    public function __construct(BuildingEntity $building) {
        $this->level = $building->getLevel();
        $this->name = $building->getName();
    }
}
