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

        $this->createAccountShema($shema);
        $this->createCityShema($shema);
        $this->createBuildingsShema($shema);

        return $shema;
    }

    private function createTable($tableName, $shema) {

        if (!$shema->hasTable($tableName)) {
            $table = $shema->createTable($tableName);
        } else {
            $table = $shema->getTable($tableName);
        }
        return $table;
    }

    private function createCityShema(&$shema) {
        $cities = $this->createTable('cities', $shema);
        $cities->addColumn('id', Type::INTEGER, array('length' => 11));
        $cities->addColumn('name', Type::STRING, array('length' => 254));
        $cities->addColumn('x', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cities->addColumn('y', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cities->addColumn('user_id', Type::INTEGER, array('length' => 11));
        $cities->setPrimaryKey(array("id"));
    }

    private function createBuildingsShema(&$shema) {

        $buildings = $this->createTable('buildings', $shema);
        $buildings->addColumn('id', Type::INTEGER, array('length' => 11));
        $buildings->addColumn('name', Type::STRING, array('length' => 254));
        $buildings->addColumn('minimum_level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $buildings->addColumn('maximum_level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $buildings->setPrimaryKey(array("id"));

        $cityBuildings = $this->createTable('city_buildings', $shema);
        $cityBuildings->addColumn('city_id', Type::INTEGER, array('length' => 11));
        $cityBuildings->addColumn('building_id', Type::INTEGER, array('length' => 11));
        $cityBuildings->addColumn('level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cityBuildings->setPrimaryKey(array("city_id", 'building_id'));
    }

    private function createAccountShema(&$shema) {
        $users = $this->createTable('users', $shema);
        $users->addColumn('id', Type::INTEGER, array('length' => 11));
        $users->addColumn('username', Type::STRING, array('length' => 254));
        $users->addColumn('password', Type::STRING, array('length' => 254));
        $users->addColumn('logins', Type::INTEGER, array('length' => 10, 'unsigned' => true, 'notnull' => false));
        $users->addColumn('lastLogin', Type::DATETIME, array('notnull' => false));
        $users->addColumn('registered', Type::DATETIME, array('notnull' => false));
        $users->addColumn('lastAction', Type::DATETIME, array('notnull' => false));
        $users->addColumn('activationCode', Type::STRING, array('notnull' => false));
        $users->addColumn('email', Type::STRING);
        $users->setPrimaryKey(array("id"));

        $roles = $this->createTable('roles', $shema);
        $roles->addColumn('id', Type::INTEGER);
        $roles->addColumn('name', Type::STRING, array('length' => 32));
        $roles->addColumn('description', Type::STRING, array('length' => 254));
        $roles->setPrimaryKey(array("id"));

        $userRoles = $this->createTable('user_roles', $shema);
        $userRoles->addColumn('user_id', Type::INTEGER);
        $userRoles->addColumn('role_id', Type::INTEGER);
        $userRoles->setPrimaryKey(array('user_id', 'role_id'));
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
