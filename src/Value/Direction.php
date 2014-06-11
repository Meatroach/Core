<?php

namespace OpenTribes\Core\Value;

/**
 * Description of Direction
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Direction
{

    const EAST  = 0;
    const WEST  = 1;
    const NORTH = 2;
    const SOUTH = 3;
    const ANY   = -1;

    private $value = -1;
    private $directions = array(
        'south' => self::SOUTH,
        'north' => self::NORTH,
        'west'  => self::WEST,
        'east'  => self::EAST,
        'any'   => self::ANY
    );

    public function __construct($value)
    {
        if (is_string($value) && !is_numeric($value) && isset($this->directions[$value])) {
            $value = $this->directions[$value];

        }

        if ($this->isValid($value)) {
            $this->value = $value;
        }
    }

    public function __toString()
    {
        return (string)$this->value;
    }

    public function getValue()
    {
        return $this->value;
    }

    public static function north()
    {
        return new Direction(self::NORTH);
    }

    public static function south()
    {
        return new Direction(self::SOUTH);
    }

    public static function west()
    {
        return new Direction(self::WEST);
    }

    public static function east()
    {
        return new Direction(self::EAST);
    }

    public static function any()
    {
        return new Direction(self::ANY);
    }

    private function isValid($value)
    {
        return in_array($value, ($this->directions));
    }

}
