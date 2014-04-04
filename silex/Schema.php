<?php

namespace OpenTribes\Core\Silex;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Schema\Schema as DoctrineSchema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

class Schema {

    private $connection;

    public function __construct(Connection $connection) {
        $this->connection = $connection;
    }

    public function installSchema() {
        $sm              = $this->connection->getSchemaManager();
        $installedSchema = $sm->createSchema();
        $newSchema       = $this->createSchema(new DoctrineSchema);
        $sql             = $installedSchema->getMigrateToSql($newSchema, $this->connection->getDatabasePlatform());

        foreach ($sql as $statement) {
            $this->connection->exec($statement);
            echo sprintf("Execute Statment: %s \n", $statement);
        }
    }

    /**
     * @param DoctrineSchema $schema
     *
     * @return DoctrineSchema
     */
    private function createSchema(&$schema) {


        $this->createAccountSchema($schema);
        $this->createCitySchema($schema);
        $this->createBuildingsSchema($schema);
        $this->createMapSchema($schema);
        return $schema;
    }
    /**
     *
     * @param string $tableName
     * @param DoctrineSchema $schema
     * @return Table
     */
    private function createTable($tableName, $schema) {

        if (!$schema->hasTable($tableName)) {
            $table = $schema->createTable($tableName);
        } else {
            $table = $schema->getTable($tableName);
        }
        return $table;
    }

    private function createMapSchema(&$schema) {
        $map = $this->createTable('maps', $schema);
        $map->addColumn('id', Type::INTEGER, array('length' => 11));
        $map->addColumn('name', Type::STRING, array('length' => 254));
        $map->addColumn('width', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $map->addColumn('height', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $map->setPrimaryKey(array('id'));

        $tile     = $this->createTable('tiles', $schema);
        $tile->addColumn('id', Type::INTEGER, array('length' => 11));
        $tile->addColumn('name', Type::STRING, array('length' => 254));
        $tile->addColumn('accessable', Type::BOOLEAN);
        $tile->setPrimaryKey(array('id'));

        $mapTiles = $this->createTable('map_tiles', $schema);
        $mapTiles->addColumn('x', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $mapTiles->addColumn('y', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $mapTiles->addColumn('map_id', Type::INTEGER, array('length' => 11));
        $mapTiles->addColumn('tile_id', Type::INTEGER, array('length' => 11));
        $mapTiles->setPrimaryKey(array('map_id', 'tile_id', 'x', 'y'));
        $mapTiles->addForeignKeyConstraint($map, array('map_id'), array('id'), array(), 'map');
        $mapTiles->addForeignKeyConstraint($tile, array('tile_id'), array('id'), array(), 'tile');
    }

    private function createCitySchema(&$schema) {
        $cities = $this->createTable('cities', $schema);

        $cities->addColumn('id', Type::INTEGER, array('length' => 11));
        $cities->addColumn('name', Type::STRING, array('length' => 254));
        $cities->addColumn('x', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cities->addColumn('y', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cities->addColumn('user_id', Type::INTEGER, array('length' => 11));

        $cities->setPrimaryKey(array("id"));
        $cities->addForeignKeyConstraint('users', array('user_id'), array('id'), array(), 'user');
    }

    private function createBuildingsSchema(&$schema) {

        $buildings = $this->createTable('buildings', $schema);
        $buildings->addColumn('id', Type::INTEGER, array('length' => 11));
        $buildings->addColumn('name', Type::STRING, array('length' => 254));
        $buildings->addColumn('minimum_level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $buildings->addColumn('maximum_level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $buildings->setPrimaryKey(array("id"));

        $cityBuildings = $this->createTable('city_buildings', $schema);
        $cityBuildings->addColumn('city_id', Type::INTEGER, array('length' => 11));
        $cityBuildings->addColumn('building_id', Type::INTEGER, array('length' => 11));
        $cityBuildings->addColumn('level', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $cityBuildings->setPrimaryKey(array("city_id", 'building_id'));
    }

    private function createAccountSchema(&$schema) {
        $users = $this->createTable('users', $schema);
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

        $roles = $this->createTable('roles', $schema);
        $roles->addColumn('id', Type::INTEGER);
        $roles->addColumn('name', Type::STRING, array('length' => 32));
        $roles->addColumn('description', Type::STRING, array('length' => 254));
        $roles->setPrimaryKey(array("id"));

        $userRoles = $this->createTable('user_roles', $schema);
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
