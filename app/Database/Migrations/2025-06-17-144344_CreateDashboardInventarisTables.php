<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDashboardInventarisTables extends Migration
{
    public function up()
    {
        // Tabel users
        $this->forge->addField([
            'user_id'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'first_name'   => ['type' => 'VARCHAR', 'constraint' => 100],
            'last_name'    => ['type' => 'VARCHAR', 'constraint' => 100],
            'email'        => ['type' => 'VARCHAR', 'constraint' => 255],
            'password'     => ['type' => 'VARCHAR', 'constraint' => 255],
            'created_at'   => ['type' => 'DATETIME', 'null' => true],
            'updated_at'   => ['type' => 'DATETIME', 'null' => true],
            'role'         => ['type' => 'INT', 'constraint' => 10, 'default' => 2],
        ]);
        $this->forge->addKey('user_id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->createTable('users');

        // Tabel customer
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
        $this->forge->createTable('customer');

        // Tabel status
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true],
            'status_name' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('status');

        // Tabel tb_barang
        $this->forge->addField([
            'barang_id'          => ['type' => 'VARCHAR', 'constraint' => 50],
            'nama_barang'        => ['type' => 'VARCHAR', 'constraint' => 100],
            'kategori_alat'      => ['type' => 'VARCHAR', 'constraint' => 50],
            'merek'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'spesifikasi'        => ['type' => 'TEXT', 'null' => true],
            'tahun_pengadaan'    => ['type' => 'YEAR', 'null' => true],
            'sumber_anggaran'    => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'lokasi_penyimpanan' => ['type' => 'TEXT', 'null' => true],
            'kondisi'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'catatan'            => ['type' => 'TEXT', 'null' => true],
            'jumlah_stok'        => ['type' => 'INT', 'constraint' => 10],
            'user_id'            => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at'         => ['type' => 'DATETIME', 'null' => true],
            'updated_at'         => ['type' => 'DATETIME', 'null' => true],
            'status'             => ['type' => 'INT', 'constraint' => 10, 'null' => true],
        ]);
        $this->forge->addKey('barang_id', true);
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'NO ACTION', 'NO ACTION');
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
            'customer_id'      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'user_id'          => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
        ]);
        $this->forge->addKey('transaksi_id', true);
        $this->forge->addForeignKey('customer_id', 'customer', 'customer_id', 'NO ACTION', 'NO ACTION');
        $this->forge->addForeignKey('user_id', 'users', 'user_id', 'NO ACTION', 'NO ACTION');
        $this->forge->createTable('tb_transaksi');

        // Tabel tb_detail_transaksi
        $this->forge->addField([
            'id_detail'     => ['type' => 'INT', 'constraint' => 10, 'auto_increment' => true],
            'transaksi_id'  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'barang_id'     => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'jumlah'        => ['type' => 'INT', 'constraint' => 10, 'null' => true],
            'spesifikasi'   => ['type' => 'TEXT', 'null' => true],
        ]);
        $this->forge->addKey('id_detail', true);
        $this->forge->addForeignKey('transaksi_id', 'tb_transaksi', 'transaksi_id', 'NO ACTION', 'NO ACTION');
        $this->forge->addForeignKey('barang_id', 'tb_barang', 'barang_id', 'NO ACTION', 'NO ACTION');
        $this->forge->createTable('tb_detail_transaksi');
    }

    public function down()
    {
        $this->forge->dropTable('tb_detail_transaksi');
        $this->forge->dropTable('tb_transaksi');
        $this->forge->dropTable('tb_barang');
        $this->forge->dropTable('status');
        $this->forge->dropTable('customer');
        $this->forge->dropTable('users');
    }
}
