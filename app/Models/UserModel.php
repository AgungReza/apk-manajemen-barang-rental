<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users'; 
    protected $primaryKey = 'user_id';
    protected $allowedFields = ['user_id','first_name', 'last_name', 'email', 'password', 'role'];
    protected $useTimestamps = true; 
}
