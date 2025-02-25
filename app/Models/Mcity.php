<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcity extends Model
{
    protected $table = 'mscity';
    protected $primaryKey = 'cityid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>