<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table = 'customer'; 
    protected $primaryKey = 'customer_id'; 
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'customer_id', 'nama_customer', 'email', 'nik_nis_nim', 'alamat', 'kelas', 'jurusan'
    ];
}
