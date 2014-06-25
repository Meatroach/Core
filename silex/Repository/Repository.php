<?php

namespace OpenTribes\Core\Silex\Repository;

/**
 * Description of Repository
 *
 * @author BlackScorp<witalimik@web.de>
 */
abstract class Repository
{

    private $added = array();
    private $modified = array();
    private $deleted = array();

    /**
     * @param integer $key
     */
    protected function reassign($key)
    {
        if (isset($this->added[$key])) {
            unset($this->added[$key]);
        }
        if (isset($this->modified[$key])) {
            unset($this->modified[$key]);
        }
        if (isset($this->deleted[$key])) {
            unset($this->deleted[$key]);
        }
    }

    /**
     * @param integer $key
     */
    protected function markDeleted($key)
    {
        $this->reassign($key);
        $this->deleted[$key] = $key;
    }

    /**
     * @param integer $key
     */
    protected function markModified($key)
    {
        $this->reassign($key);
        $this->modified[$key] = $key;
    }

    /**
     * @param integer $key
     */
    protected function markAdded($key)
    {
        $this->reassign($key);
        $this->added[$key] = $key;
    }

    /**
     * @return integer[]
     */
    protected function getAdded()
    {
        return $this->added;
    }

    /**
     * @return integer[]
     */
    protected function getModified()
    {
        return $this->modified;
    }

    /**
     * @return integer[]
     */
    protected function getDeleted()
    {
        return $this->deleted;
    }
}
