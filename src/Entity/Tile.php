<?php

namespace OpenTribes\Core\Entity;

/**
 * Tile Entity
 *
 * @author BlackScorp<witalimik@web.de>
 */
class Tile {

    /**
     * @var \string
     */
    private $name;

    /**
     * @var \boolean
     */
    private $accessible;

    /**
     * @var \integer
     */
    private $id;

    /**
     * @param \integer $id
     * @param \string $name
     * @param \boolean $accessible
     */
    public function __construct($id, $name, $accessible) {
        $this->name       = $name;
        $this->accessible = (bool) $accessible;
        $this->id         = (int) $id;
    }

    /**
     * @return \string
     */
    public function getName() {
        return $this->name;
    }

    /**
     * @return \boolean
     */
    public function isAccessible() {
        return $this->accessible;
    }

    /**
     * @return \integer
     */
    public function getId() {
        return $this->id;
    }

}
