<?php

namespace OpenTribes\Core\Entity;

/**
 * Description of Building
 *
 * @author Witali
 */
class Building {

    private $id;
    private $name;
    private $level;
    private $minimumLevel;
    private $maximumLevel;

    function __construct($id, $name, $minimumLevel, $maximumLevel) {
        $this->id           = $id;
        $this->name         = $name;
        $this->minimumLevel = $minimumLevel;
        $this->maximumLevel = $maximumLevel;
    }

    public function setLevel($level) {
        if ($level <= $this->maximumLevel && $level >= $this->minimumLevel) {
            $this->level = $level;
        }
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getLevel() {
        if (!$this->level) {
            return $this->minimumLevel;
        }
        return $this->level;
    }

    public function getMinimumLevel() {
        return $this->minimumLevel;
    }

    public function getMaximumLevel() {
        return $this->maximumLevel;
    }

}
