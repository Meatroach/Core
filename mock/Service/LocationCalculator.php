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
    private $centerX;
    private $centerY;
    private $countCities = 0;

    public function __construct($centerY, $centerX, $countCities) {
        $this->centerX     = $centerX;
        $this->centerY     = $centerY;
        $this->countCities = $countCities;
    }

    public function calculate(Direction $direction) {


        $direction = $direction->getValue();
        if ($direction === Direction::ANY) {
            $square    = ceil(sqrt(4 * $this->countCities));
            $direction = $square % 4;
        }
        if ($direction === Direction::NORTH) {
            $x = -1;
            $y = -1;
        }
        if ($direction === Direction::EAST) {
            $x = 1;
            $y = -1;
        }
        if ($direction === Direction::SOUTH) {

            $x = 1;
            $y = 1;
        }
        if ($direction === Direction::WEST) {
            $x = -1;
            $y = 1;
        }
        $x             = $this->centerX +$x;
        $y             = $this->centerY +$y;
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
