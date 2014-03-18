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

    private $x;
    private $y;
    private $centerX;
    private $centerY;
    private $countCities = 0;
    public function __construct($centerY,$centerX,$countCities) {
        $this->centerX = $centerX;
        $this->centerY = $centerY;
        $this->countCities = $countCities;
    }

    public function calculate(Direction $direction) {
        $x = 0;
        $y = 0;
        if($direction === Direction::ANY){
            $square = ~sqrt(4*$this->countCities);
            $direction = $square%4;
        }
        if($direction === Direction::WEST){
            $x = 1;
            $y = 0;
        }
        if($direction === Direction::NORTH){
            $x = 0;
            $y = -1;
        }
        if($direction === Direction::EAST){
            $x = -1;
            $y = 0;
        }
        if($direction === Direction::SOUTH){
            $x = 0;
            $y = 1;
        }
        var_dump($direction);
        $this->x = $this->centerX+$x;
        $this->y = $this->centerY+$y;
    }

    public function getX() {
        return $this->x;
    }

    public function getY() {
        return $this->y;
    }

}
