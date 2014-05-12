<?php

namespace OpenTribes\Core\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Schema\Table;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class VersionInitial extends AbstractMigration {

    /**
     * @var Table
     */
    private $table;

    public function up(Schema $schema) {


        $this->table = $schema->createTable('users');

        $this->table->addColumn('id', Type::INTEGER, array('length' => 11, 'autoincrement' => true));
        $this->table->addColumn('username', Type::STRING, array('length' => 254));
        $this->table->addColumn('password', Type::STRING, array('length' => 254));
        $this->table->addColumn('logins', Type::INTEGER, array('length' => 10, 'unsigned' => true, 'default' => 0));
        $this->table->addColumn('lastLogin', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('registered', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('lastAction', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('activationCode', Type::STRING, array('notnull' => false));
        $this->table->addColumn('email', Type::STRING);
        $this->table->setPrimaryKey(array("id"));
        $userTable   = $this->table;

        $this->table = $schema->createTable('roles');
        $this->table->addColumn('id', Type::INTEGER, array('autoincrement' => true));
        $this->table->addColumn('name', Type::STRING, array('length' => 32));
        $this->table->addColumn('description', Type::TEXT);
        $this->table->setPrimaryKey(array("id"));
        $rolesTable  = $this->table;

        $this->table = $schema->createTable('user_roles');
        $this->table->addColumn('user_id', Type::INTEGER);
        $this->table->addColumn('role_id', Type::INTEGER);
        $this->table->setPrimaryKey(array('user_id', 'role_id'));
        $this->table->addForeignKeyConstraint($userTable, array('user_id'), array('id'), array(), 'fk_user');
        $this->table->addForeignKeyConstraint($rolesTable, array('role_id'), array('id'), array(), 'fk_role');

        $this->table = $schema->createTable('maps');
        $this->table->addColumn('id', Type::INTEGER, array('length' => 11, 'autoincrement' => true));
        $this->table->addColumn('name', Type::STRING, array('length' => 254));
        $this->table->addColumn('width', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('height', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->setPrimaryKey(array('id'));
        $mapTable    = $this->table;

        $this->table = $schema->createTable('tiles');
        $this->table->addColumn('id', Type::INTEGER, array('length' => 11, 'autoincrement' => true));
        $this->table->addColumn('name', Type::STRING, array('length' => 254));
        $this->table->addColumn('is_accessible', Type::BOOLEAN);
        $this->table->addColumn('is_default', Type::BOOLEAN);
        $this->table->addColumn('width', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('height', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->setPrimaryKey(array('id'));
        $tileTable   = $this->table;

        $this->table = $schema->createTable('map_tiles');
        $this->table->addColumn('x', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('y', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('map_id', Type::INTEGER, array('length' => 11));
        $this->table->addColumn('tile_id', Type::INTEGER, array('length' => 11));
        $this->table->setPrimaryKey(array('map_id', 'tile_id', 'x', 'y'));
        $this->table->addForeignKeyConstraint($mapTable, array('map_id'), array('id'), array(), 'fk_map');
        $this->table->addForeignKeyConstraint($tileTable, array('tile_id'), array('id'), array(), 'fk_tile');


        $this->table = $schema->createTable('cities');

        $this->table->addColumn('id', Type::INTEGER, array('length' => 11, 'autoincrement' => true));
        $this->table->addColumn('name', Type::STRING, array('length' => 254));
        $this->table->addColumn('x', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('y', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('user_id', Type::INTEGER, array('length' => 11, 'notnull' => false));
        $this->table->addColumn('set_main', Type::BOOLEAN);
        $this->table->setPrimaryKey(array('id', 'x', 'y'));
        $this->table->addForeignKeyConstraint($userTable, array('user_id'), array('id'), array('onDelete' => 'SET NULL', 'onUpdate' => 'NO ACTIOn'), 'fk_city_owner');
    }

    public function down(Schema $schema) {
        $schema->dropTable('user_roles');
        $schema->dropTable('users');
        $schema->dropTable('roles');
        $schema->dropTable('maps');
        $schema->dropTable('tiles');
        $schema->dropTable('map_tiles');
        $schema->dropTable('cities');
    }

}
