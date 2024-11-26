<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTbBarangTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'barang_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_barang' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kategori_alat' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'merek' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'spesifikasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'tahun_pengadaan' => [
                'type' => 'YEAR',
                'null' => true,
            ],
            'sumber_anggaran' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'lokasi_penyimpanan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kondisi' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'catatan' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'jumlah_stok' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('barang_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_barang');
    }

    public function down()
    {
        $this->forge->dropTable('tb_barang');
    }
}
