<?php

namespace OpenTribes\Core\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Schema\Table;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Map extends AbstractMigration {

    /**
     *
     * @var Table 
     */
    private $table;

    public function up(Schema $schema) {
        $this->table = $schema->createTable('maps');
        $this->table->addColumn('id', Type::INTEGER, array('length' => 11));
        $this->table->addColumn('name', Type::STRING, array('length' => 254));
        $this->table->addColumn('width', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->addColumn('height', Type::INTEGER, array('length' => 11, 'unsigned' => true));
        $this->table->setPrimaryKey(array('id'));
        $mapTable    = $this->table;

        $this->table = $schema->createTable('tiles');
        $this->table->addColumn('id', Type::INTEGER, array('length' => 11));
        $this->table->addColumn('name', Type::STRING, array('length' => 254));
        $this->table->addColumn('accessable', Type::BOOLEAN);
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
    }

    public function down(Schema $schema) {
        $schema->dropTable('maps');
        $schema->dropTable('tiles');
        $schema->dropTable('map_tiles');
    }

}
