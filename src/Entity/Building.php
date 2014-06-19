<?php

namespace OpenTribes\Core\Entity;

/**
 * Building Entity
 *
 * @author Witali
 */
class Building
{

    /**
     * @var integer
     */
    private $buildingId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var integer
     */
    private $level;

    /**
     * @var integer
     */
    private $minimumLevel;

    /**
     * @var integer
     */
    private $maximumLevel;

    /**
     * @param integer $buildingId
     * @param string $name
     * @param integer $minimumLevel
     * @param integer $maximumLevel
     */
    public function __construct($buildingId, $name, $minimumLevel, $maximumLevel)
    {
        $this->buildingId = (int)$buildingId;
        $this->name         = $name;
        $this->minimumLevel = (int)$minimumLevel;
        $this->maximumLevel = (int)$maximumLevel;
    }

    /**
     * @param integer $level
     */
    public function setLevel($level)
    {
        $level = (int)$level;
        if ($level <= $this->maximumLevel && $level >= $this->minimumLevel) {
            $this->level = $level;
        }
    }

    /**
     * @return integer
     */
    public function getBuildingId()
    {
        return $this->buildingId;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return integer
     */
    public function getLevel()
    {
        if (!$this->level) {
            return $this->minimumLevel;
        }
        return $this->level;
    }

    /**
     * @return integer
     */
    public function getMinimumLevel()
    {
        return $this->minimumLevel;
    }

    /**
     * @return integer
     */
    public function getMaximumLevel()
    {
        return $this->maximumLevel;
    }

}
