<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePublicInformationsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'title'         => ['type' => 'VARCHAR', 'constraint' => 500],
        'category'      => ['type' => 'ENUM', 'constraint' => ['berkala', 'serta_merta', 'tersedia', 'dikecualikan'], 'default' => 'berkala'],
        'sub_category'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'description'   => ['type' => 'TEXT', 'null' => true],
        'file_path'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'external_link' => ['type' => 'VARCHAR', 'constraint' => 500, 'null' => true],
        'year'          => ['type' => 'YEAR', 'null' => true],
        'sort_order'    => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        'is_active'     => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        'created_at'    => ['type' => 'DATETIME', 'null' => true],
        'updated_at'    => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('public_informations');
}

    public function down()
    {
        $this->forge->dropTable('public_informations');
    }
}
