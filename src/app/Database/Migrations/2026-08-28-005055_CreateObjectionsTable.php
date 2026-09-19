<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateObjectionsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'           => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'request_id'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'user_id'      => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'reason'       => ['type' => 'TEXT'],
        'status'       => ['type' => 'ENUM', 'constraint' => ['pending', 'process', 'resolved'], 'default' => 'pending'],
        'response'     => ['type' => 'TEXT', 'null' => true],
        'responded_by' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        'responded_at' => ['type' => 'DATETIME', 'null' => true],
        'created_at'   => ['type' => 'DATETIME', 'null' => true],
        'updated_at'   => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('request_id');
    $this->forge->createTable('objections');
}

    public function down()
    {
        $this->forge->dropTable('objections');
    }
}
