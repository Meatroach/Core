<?php

namespace OpenTribes\Core\Service;

use OpenTribes\Core\Value\Direction;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface LocationCalculator
{

    /**
     * @return void
     */
    public function calculate(Direction $direction);

    /**
     * @return integer
     */
    public function getX();

    /**
     * @return integer
     */
    public function getY();

    /**
     * @param integer $posY
     * @param integer $posX
     *
     * @return void
     */
    public function setCenterPosition($posY, $posX);

    /**
     * @param integer $countCities
     * @return void
     */
    public function setCountCities($countCities);

    /**
     * @return void
     */
    public function increaseRadius();
}
