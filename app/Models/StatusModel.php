<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $allowedFields = ['status_name'];

    public function getAllStatus()
    {
        return $this->findAll();
    }
}
