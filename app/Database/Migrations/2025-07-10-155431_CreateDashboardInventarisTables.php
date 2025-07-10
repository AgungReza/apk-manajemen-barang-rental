<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDashboardInventarisTables extends Migration
{
    public function up()
    {
        // Tabel users
        $this->forge->addField([
            'user_id'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'first_name' => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name'  => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'      => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'   => ['type' => 'VARCHAR', 'constraint' => 255],
            'role'       => ['type' => 'INT', 'constraint' => 10, 'default' => 2],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');

        // Tabel customers
        $this->forge->addField([
            'customer_id'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_customer' => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'NIK_NIS_NIM'   => ['type' => 'VARCHAR', 'constraint' => 50],
            'alamat'        => ['type' => 'TEXT', 'null' => true],
            'kelas'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'jurusan'       => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addKey('customer_id', true);
        $this->forge->createTable('customers');

        // Tabel status
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 10],
            'status_name' => ['type' => 'VARCHAR', 'constraint' => 50],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('status');

        // Insert default status values
        $this->db->table('status')->insertBatch([
            ['id' => 1, 'status_name' => 'diambil'],
            ['id' => 2, 'status_name' => 'dipesan'],
            ['id' => 3, 'status_name' => 'dibatalkan'],
            ['id' => 4, 'status_name' => 'dikembalikan'],
        ]);

        // Tabel tb_barang
        $this->forge->addField([
            'barang_id'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_barang'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'kategori_alat'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'merek'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'spesifikasi'        => ['type' => 'TEXT', 'null' => true],
            'tahun_pengadaan'    => ['type' => 'VARCHAR', 'constraint' => 4, 'null' => true],
            'sumber_anggaran'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'lokasi_penyimpanan' => ['type' => 'TEXT', 'null' => true],
            'kondisi'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'catatan'            => ['type' => 'TEXT', 'null' => true],
            'jumlah_stok'        => ['type' => 'INT', 'constraint' => 10],
            'user_id'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'status'             => ['type' => 'INT', 'constraint' => 10, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('barang_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tb_barang');

        // Tabel tb_transaksi
        $this->forge->addField([
            'transaksi_id'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'type_transaksi'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'tanggal_keluar'   => ['type' => 'DATE', 'null' => true],
            'jam_keluar'       => ['type' => 'TIME', 'null' => true],
            'tanggal_kembali'  => ['type' => 'DATE', 'null' => true],
            'jam_kembali'      => ['type' => 'TIME', 'null' => true],
            'status_transaksi' => ['type' => 'TINYINT', 'constraint' => 3, 'null' => true],
            'catatan'          => ['type' => 'TEXT', 'null' => true],
            'customer_id'      => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'user_id'          => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'durasi_sewa'      => ['type' => 'INT', 'constraint' => 10, 'default' => 1],
            'diskon'           => ['type' => 'INT', 'constraint' => 10, 'default' => 0],
            'total_harga'      => ['type' => 'INT', 'constraint' => 10, 'default' => 0],
        ]);
        $this->forge->addKey('transaksi_id', true);
        $this->forge->addForeignKey('customer_id', 'customers', 'customer_id', 'SET NULL', 'CASCADE');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'SET NULL', 'CASCADE');
        $this->forge->createTable('tb_transaksi');

        // Tabel tb_detail_transaksi
        $this->forge->addField([
            'id_detail'     => ['type' => 'INT', 'constraint' => 10, 'unsigned' => true, 'auto_increment' => true],
            'transaksi_id'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'barang_id'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'jumlah'        => ['type' => 'INT', 'constraint' => 10, 'null' => true],
            'spesifikasi'   => ['type' => 'TEXT', 'null' => true],
            'harga'         => ['type' => 'INT', 'constraint' => 10, 'default' => 0],
        ]);
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('transaksi_id', 'tb_transaksi', 'transaksi_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('barang_id', 'tb_barang', 'barang_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tb_detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_detail_transaksi', true);
        $this->forge->dropTable('tb_transaksi', true);
        $this->forge->dropTable('tb_barang', true);
        $this->forge->dropTable('status', true);
        $this->forge->dropTable('customers', true);
        $this->forge->dropTable('users', true);
    }
}
