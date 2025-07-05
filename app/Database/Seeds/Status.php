<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Status extends Seeder
{
    public function run()
    {
         $data = [
            ['status_name' => 'diambil'],
            ['status_name' => 'dipesan'],
            ['status_name' => 'dibatalkan'],
            ['status_name' => 'dikembalikan'],
        ];
        $this->db->table('status')->insertBatch($data);
    }

}
