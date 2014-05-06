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
    private $originX;
    private $originY;
    private $countCities = 0;
    private $margin = 0;
  
    public function setOriginPosition($y,$x){
        $this->originX = $x;
        $this->originY = $y;
    }
    public function setCountCities($countCities){
        $this->countCities = $countCities;
    }
  

    public function calculate(Direction $direction) {

        $x         = 0;
        $y         = 0;
        $direction = $direction->getValue();
        if ($direction === Direction::ANY) {
            $square    = ceil(sqrt(4 * $this->countCities));
            $direction = $square % 4;
        }
        if ($direction === Direction::NORTH) {
            $x = -$this->margin;
            $y = -$this->margin;
        }
        if ($direction === Direction::EAST) {
            $x = $this->margin;
            $y = -$this->margin;
        }
        if ($direction === Direction::SOUTH) {

            $x = $this->margin;
            $y = $this->margin;
        }
        if ($direction === Direction::WEST) {
            $x = -$this->margin;
            $y = $this->margin;
        }
        $x             = $this->originX +$x;
        $y             = $this->originY +$y;
        $minX          = $x - 1;
        $maxX          = $x + 1;
        $minY          = $y - 1;
        $maxY          = $y + 1;
        $x  = mt_rand($minX, $maxX);
        $y =  mt_rand($minY, $maxY);
        $this->x       = $x;
        $this->y       = $y;
        
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

}
