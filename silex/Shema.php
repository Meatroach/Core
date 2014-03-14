<?php

namespace OpenTribes\Core\Silex;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;

class Shema {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function installShema() {
        $sm = $this->connection->getSchemaManager();

        $installedShema = $sm->createSchema();
        $newShema       = $this->getShema();
        $sql            = $installedShema->getMigrateToSql($newShema, $this->connection->getDatabasePlatform());
        foreach ($sql as $statement) {
            $this->connection->exec($statement);
            echo sprintf("Execute Statment: %s \n", $statement);
        }
    }

    private function getShema() {
        $shema = new Schema;

        $users = $shema->createTable('users');
        $users->addColumn('id', Type::INTEGER, array('length' => 11));
        $users->addColumn('username', Type::STRING, array('length' => 254));
        $users->addColumn('password', Type::STRING, array('length' => 254));
        $users->addColumn('logins', Type::INTEGER, array('length' => 10, 'unsigned' => true,'notnull'=>false));
        $users->addColumn('lastLogin', Type::DATETIME, array('notnull' => false));
        $users->addColumn('registered', Type::DATETIME, array('notnull' => false));
        $users->addColumn('lastAction', Type::DATETIME, array('notnull' => false));
        $users->addColumn('activationCode', Type::STRING, array('notnull' => false));

        $users->addColumn('email', Type::STRING);
        $users->setPrimaryKey(array("id"));

        $roles = $shema->createTable('roles');
        $roles->addColumn('id', Type::INTEGER);
        $roles->addColumn('name', Type::STRING, array('length' => 32));
        $roles->addColumn('description', Type::STRING, array('length' => 254));
        $roles->setPrimaryKey(array("id"));

        $userRoles = $shema->createTable('user_roles');
        $userRoles->addColumn('user_id', Type::INTEGER);
        $userRoles->addColumn('role_id', Type::INTEGER);
        $userRoles->setPrimaryKey(array('user_id', 'role_id'));


        return $shema;
    }

    public function createRoles() {

        $this->connection->insert('roles', array(
            'id'          => 1,
            'name'        => 'Guest',
            'description' => 'Guest role'
        ));
        $this->connection->insert('roles', array(
            'id'          => 2,
            'name'        => 'User',
            'description' => 'User role'
        ));
        $this->connection->insert('roles', array(
            'id'          => 3,
            'name'        => 'Admin',
            'description' => 'Admin role'
        ));
    }

}
