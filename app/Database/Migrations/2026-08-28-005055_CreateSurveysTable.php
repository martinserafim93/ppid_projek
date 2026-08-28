<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSurveysTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'request_id'  => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'user_id'     => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
        'rating'      => ['type' => 'TINYINT', 'constraint' => 1],
        'feedback'    => ['type' => 'TEXT', 'null' => true],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addKey('request_id');
    $this->forge->createTable('surveys');
}

    public function down()
    {
        $this->forge->dropTable('surveys');
    }
}
