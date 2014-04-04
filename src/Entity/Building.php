<?php

namespace OpenTribes\Core\Entity;

/**
 * Building Entity
 *
 * @author Witali
 */
class Building {

    /**
     * @var \integer
     */
    private $id;

    /**
     * @var \string
     */
    private $name;

    /**
     * @var \integer
     */
    private $level;

    /**
     * @var \integer
     */
    private $minimumLevel;

    /**
     * @var \integer
     */
    private $maximumLevel;

    /**
     * @param integer $id
     * @param string $name
     * @param integer $minimumLevel
     * @param integer $maximumLevel
     */
    function __construct($id, $name, $minimumLevel, $maximumLevel) {
        $this->id           = (int) $id;
        $this->name         = $name;
        $this->minimumLevel = (int) $minimumLevel;
        $this->maximumLevel = (int) $maximumLevel;
    }

    /**
     * @param integer $level
     */
    public function setLevel($level) {
        $level = (int) $level;
        if ($level <= $this->maximumLevel && $level >= $this->minimumLevel) {
            $this->level = $level;
        }
    }

    /**
     * @return integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getLevel() {
        if (!$this->level) {
            return $this->minimumLevel;
        }
        return $this->level;
    }

    /**
     * @return integer
     */
    public function getMinimumLevel() {
        return $this->minimumLevel;
    }

    /**
     * @return integer
     */
    public function getMaximumLevel() {
        return $this->maximumLevel;
    }

}
