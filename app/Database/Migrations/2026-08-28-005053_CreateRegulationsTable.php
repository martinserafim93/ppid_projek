<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRegulationsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'title'       => ['type' => 'VARCHAR', 'constraint' => 500],
        'type'        => ['type' => 'ENUM', 'constraint' => ['uu', 'pp', 'perki', 'pma', 'sk'], 'default' => 'uu'],
        'number'      => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        'year'        => ['type' => 'YEAR', 'null' => true],
        'description' => ['type' => 'TEXT', 'null' => true],
        'file_path'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
        'updated_at'  => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('regulations');
}

    public function down()
    {
        $this->forge->dropTable('regulations');
    }
}
