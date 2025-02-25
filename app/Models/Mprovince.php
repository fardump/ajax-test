<?php

namespace App\Models;

use CodeIgniter\Model;

class Mprovince extends Model
{
    protected $table = 'msprovince';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>