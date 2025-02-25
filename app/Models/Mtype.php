<?php

namespace App\Models;

use CodeIgniter\Model;

class Mtype extends Model
{
    protected $table = 'mstype';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>