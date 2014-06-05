<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\LocationCalculator as LocationCalculatorInterface;
use OpenTribes\Core\Value\Direction;

/**
 * Description of LocationCalculator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class LocationCalculator implements LocationCalculatorInterface {

    private $x           = 0;
    private $y           = 0;
    private $centerX     = 0;
    private $centerY     = 0;
    private $countCities = 0;


    public function setCenterPosition($y,$x){
        $this->centerX = $x;
        $this->centerY = $y;
    }
    public function setCountCities($countCities){
        $this->countCities = $countCities;
    }


    public function calculate(Direction $direction) {
        $direction = $direction->getValue();
        if ($direction === Direction::ANY) {
            $direction = $this->countCities % 4;
        }
        $degree = mt_rand($direction*90,($direction+1)*90);

        $phi = deg2rad($degree);
        $radius = pow($phi,2);
        var_dump($direction);
        $x = ~~($radius*cos($phi))+$this->centerX;
        $y = ~~($radius*sin($phi))+$this->centerY;
        var_dump($x,$y);
        $this->x = $x;
        $this->y = $y;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

}
