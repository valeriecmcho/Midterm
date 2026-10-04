<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table         = 'users';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['username', 'full_name', 'password', 'avatar', 'created_at'];
    protected $useTimestamps = false;

    // Never return password in listings — callers can still access via findAll() directly
}
