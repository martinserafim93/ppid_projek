<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateRequestsTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'             => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'ticket_number'  => ['type' => 'VARCHAR', 'constraint' => 50],
        'user_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'subject'        => ['type' => 'VARCHAR', 'constraint' => 500],
        'description'    => ['type' => 'TEXT'],
        'purpose'        => ['type' => 'TEXT', 'null' => true],
        'status'         => ['type' => 'ENUM', 'constraint' => ['pending', 'process', 'approved', 'rejected'], 'default' => 'pending'],
        'response'       => ['type' => 'TEXT', 'null' => true],
        'response_file'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'responded_by'   => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'null' => true],
        'responded_at'   => ['type' => 'DATETIME', 'null' => true],
        'created_at'     => ['type' => 'DATETIME', 'null' => true],
        'updated_at'     => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('ticket_number');
    $this->forge->addKey('user_id');
    $this->forge->createTable('requests');
}

    public function down()
    {
        $this->forge->dropTable('requests');
    }
}
