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
        $this->table->addColumn('id', Type::INTEGER, array('length' => 11));
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

        $this->table = $schema->createTable('roles', $schema);
        $this->table->addColumn('id', Type::INTEGER);
        $this->table->addColumn('name', Type::STRING, array('length' => 32));
        $this->table->addColumn('description', Type::TEXT);
        $this->table->setPrimaryKey(array("id"));
        $rolesTable  = $this->table;

        $this->table = $schema->createTable('user_roles', $schema);
        $this->table->addColumn('user_id', Type::INTEGER);
        $this->table->addColumn('role_id', Type::INTEGER);
        $this->table->setPrimaryKey(array('user_id', 'role_id'));
        $this->table->addForeignKeyConstraint($userTable, array('user_id'), array('id'), array(), 'fk_user');
        $this->table->addForeignKeyConstraint($rolesTable, array('role_id'), array('id'), array(), 'fk_role');
    }

    public function down(Schema $schema) {
        $schema->dropTable('user_roles');
        $schema->dropTable('users');
        $schema->dropTable('roles');
    }

}
