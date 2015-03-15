<?php

namespace OpenTribes\Core\Silex\Repository;


use Doctrine\DBAL\Driver\Connection;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\NullLogger;

class DBALRepository implements LoggerAwareInterface{
    use LoggerAwareTrait;
    /**
     * @var Connection
     */
    protected $connection;
    public function __construct(Connection $connection){
        $this->connection = $connection;
        $this->logger = new NullLogger();
    }
}