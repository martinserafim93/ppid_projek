<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSlugToRegulations extends Migration
{
    public function up()
    {
        // 1) Tambah kolom slug (sementara nullable agar data lama tidak error)
        $this->forge->addColumn('regulations', [
            'slug' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true, 'after' => 'title'],
        ]);

        // 2) Backfill slug data lama dari judul (unik)
        helper('slug');
        $rows = $this->db->table('regulations')->select('id, title, slug')->get()->getResultArray();
        foreach ($rows as $r) {
            if (!empty($r['slug'])) { continue; }
            $slug = generateSlug($r['title'], \App\Models\RegulationModel::class, 'slug', (int) $r['id'], 'regulasi');
            $this->db->table('regulations')->where('id', $r['id'])->update(['slug' => $slug]);
        }

        // 3) Jadikan unik
        $this->db->query('ALTER TABLE `regulations` ADD UNIQUE INDEX `regulations_slug_unique` (`slug`)');
    }

    public function down()
    {
        $this->db->query('ALTER TABLE `regulations` DROP INDEX `regulations_slug_unique`');
        $this->forge->dropColumn('regulations', 'slug');
    }
}
