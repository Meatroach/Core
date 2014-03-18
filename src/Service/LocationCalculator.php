<?php

namespace OpenTribes\Core\Service;

/**
 *
 * @author BlackScorp<witalimik@web.de>
 */
interface LocationCalculator {
public function calculate(Direction $direction);
public function getX();
public function getY();
}
