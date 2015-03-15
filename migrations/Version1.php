<?php

namespace OpenTribes\Core\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Type;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version1 extends AbstractMigration
{

    /**
     * @var Table
     */
    private $table;

    public function up(Schema $schema)
    {


        $this->table = $schema->createTable('users');

        $this->table->addColumn('userId', Type::INTEGER, array('length' => 11, 'autoincrement' => true));
        $this->table->addColumn('username', Type::STRING, array('length' => 254));
        $this->table->addColumn('password', Type::STRING, array('length' => 254));
        $this->table->addColumn('logins', Type::INTEGER, array('length' => 10, 'unsigned' => true, 'default' => 0));
        $this->table->addColumn('lastLogin', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('registered', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('lastAction', Type::DATETIME, array('notnull' => false));
        $this->table->addColumn('activationCode', Type::STRING, array('notnull' => false));
        $this->table->addColumn('email', Type::STRING);
        $this->table->setPrimaryKey(array("userId"));


    }

    public function down(Schema $schema)
    {
        $schema->dropTable('users');
    }

}
