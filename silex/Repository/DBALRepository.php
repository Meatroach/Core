<?php
namespace OpenTribes\Core\Silex\Repository;

use Doctrine\DBAL\Connection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class DBALRepository implements LoggerAwareInterface{
    use LoggerAwareTrait;
    /**
     * @var Connection
     */
    protected $connection;
    private $added = [];
    private $modified = [];
    private $deleted = [];
    public function __construct(Connection $connection){
        $this->connection = $connection;
        $this->logger = new NullLogger();
    }
    protected function markAsAdded($id){
        $this->reset($id);
        $this->added[$id] = $id;
    }
    protected function markAsModified($id){
        $this->reset($id);
        $this->modified[$id] = $id;
    }
    protected function markAsDeleted($id){
        $this->reset($id);
        $this->deleted[$id] = $id;
    }
    protected function reset($id){
        if(isset($this->added[$id])){
            unset($this->added[$id]);
        }
        if(isset($this->modified[$id])){
            unset($this->modified[$id]);
        }
        if(isset($this->deleted[$id])){
            unset($this->deleted[$id]);
        }
    }
    /**
     * @return array
     */
    protected function getAdded()
    {
        return $this->added;
    }

    /**
     * @return array
     */
    protected function getModified()
    {
        return $this->modified;
    }

    /**
     * @return array
     */
    protected function getDeleted()
    {
        return $this->deleted;
    }

}