<?php

namespace OpenTribes\Core\Mock\Service;

use OpenTribes\Core\Service\LocationCalculator as LocationCalculatorInterface;
use OpenTribes\Core\Value\Direction;

/**
 * Description of LocationCalculator
 *
 * @author BlackScorp<witalimik@web.de>
 */
class LocationCalculator implements LocationCalculatorInterface
{

    private $x = 0;
    private $y = 0;
    private $centerX = 0;
    private $centerY = 0;
    private $countCities = 0;
    private $radius = 2;

    public function setCenterPosition($y, $x)
    {
        $this->centerX = $x;
        $this->centerY = $y;
    }

    public function setCountCities($countCities)
    {
        $this->countCities = $countCities;
    }

    public function calculate(Direction $direction)
    {


        $direction = $direction->getValue();
        if ($direction === Direction::ANY) {
            $direction = $this->countCities % 4;
        }

        $angleStart = $direction * 90;
        $angleEnd = ($direction + 1) * 90 - 1;
        $randomAngle = mt_rand($angleStart, $angleEnd);


        $radius = $this->calculateRadius();

        $phi = deg2rad($randomAngle);

        $x = $this->centerX + ~~($radius * cos($phi));
        $y = $this->centerY + ~~($radius * sin($phi));


        $this->x = $x;
        $this->y = $y;
    }

    /**
     * @return double
     */
    private function calculateRadius()
    {
        $radius = $this->radius;
        $drawn = 0;

        for ($city = 0; $city < $this->countCities; $city++) {
            if ($drawn === (int)(2 * M_PI * $radius)) {
                ++$radius;
                $drawn = 0;
            }
            ++$drawn;

        }

        return $radius;
    }

    public function getX()
    {
        return $this->x;
    }

    public function getY()
    {
        return $this->y;
    }

    public function increaseRadius()
    {
        $this->radius++;
    }

}
