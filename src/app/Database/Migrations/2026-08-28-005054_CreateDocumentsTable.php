<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'title'          => ['type' => 'VARCHAR', 'constraint' => 255],
        'description'    => ['type' => 'TEXT', 'null' => true],
        'file_path'      => ['type' => 'VARCHAR', 'constraint' => 255],
        'file_size'      => ['type' => 'INT', 'constraint' => 11, 'null' => true],
        'file_type'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        'category'       => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
        'uploaded_by'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        'download_count' => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        'is_active'      => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        'created_at'     => ['type' => 'DATETIME', 'null' => true],
        'updated_at'     => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->createTable('documents');
}

    public function down()
    {
        $this->forge->dropTable('documents');
    }
}
