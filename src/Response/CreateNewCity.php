<?php

namespace OpenTribes\Core\Response;
use OpenTribes\Core\View\City as CityView;
/**
 * Description of CreateNewCity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class CreateNewCity extends Response{
    /**
     * @var CityView
     */
    public $city;
    public $directions;
}
