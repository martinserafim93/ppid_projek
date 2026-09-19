<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePagesTable extends Migration
{
    public function up()
{
    $this->forge->addField([
        'id'          => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
        'slug'        => ['type' => 'VARCHAR', 'constraint' => 255],
        'title'       => ['type' => 'VARCHAR', 'constraint' => 255],
        'category'    => ['type' => 'ENUM', 'constraint' => ['profil_kanwil', 'profil_ppid', 'standar_layanan', 'layanan_informasi'], 'default' => 'profil_kanwil'],
        'content'     => ['type' => 'LONGTEXT', 'null' => true],
        'image'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'file_path'   => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        'sort_order'  => ['type' => 'INT', 'constraint' => 11, 'default' => 0],
        'is_active'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 1],
        'created_at'  => ['type' => 'DATETIME', 'null' => true],
        'updated_at'  => ['type' => 'DATETIME', 'null' => true],
    ]);
    $this->forge->addKey('id', true);
    $this->forge->addUniqueKey('slug');
    $this->forge->createTable('pages');
}

    public function down()
    {
        $this->forge->dropTable('pages');
    }
}
