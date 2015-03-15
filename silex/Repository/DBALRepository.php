<?php

namespace OpenTribes\Core\Silex\Repository;


use Doctrine\DBAL\Driver\Connection;

class DBALRepository {
    /**
     * @var Connection
     */
    protected $connection;
    public function __construct(Connection $connection){
        $this->connection = $connection;
    }
}