<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestFilesTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'request_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'file_path'   => ['type' => 'VARCHAR', 'constraint' => 255],
        'file_name'   => ['type' => 'VARCHAR', 'constraint' => 255],
        'file_type'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        'uploaded_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('request_id');
    $this->forge->createTable('request_files');
}

    public function down()
    {
        $this->forge->dropTable('request_files');
    }
}
