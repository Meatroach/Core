<?php

namespace OpenTribes\Core\Value;

/**
 * Description of Direction
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Direction {

    const NORTH          = 0;
    const SOUTH          = 1;
    const WEST           = 2;
    const EAST           = 3;
    const ANY            = null;

    private $value = null;

    public function __construct($value) {
        if ($this->isValid($value)) {
            $this->value = $value;
        }
    }

    public function __toString() {
        return (string)$this->value;
    }

    public static function north() {
        return new Direction(Direction::NORTH);
    }

    public static function south() {
        return new Direction(Direction::SOUTH);
    }
    public static function west(){
        return new Direction(Direction::WEST);
    }
    public static function east(){
        return new Direction(Direction::EAST);
    }
    public static function any(){
        return new Direction(Direction::ANY);
    }

    private function isValid($value) {
        return in_array($value, array(
            self::NORTH,
            self::SOUTH,
            self::WEST,
            self::EAST,
            self::ANY
        ));
    }

}
