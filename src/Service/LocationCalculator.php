<?php

namespace OpenTribes\Core\Service;

use OpenTribes\Core\Value\Direction;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface LocationCalculator {

    public function calculate(Direction $direction);

    public function getX();

    public function getY();

    public function setCenterPosition($y, $x);

    public function setCountCities($countCities);
}
