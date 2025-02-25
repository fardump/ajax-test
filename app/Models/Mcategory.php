<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcategory extends Model
{
    protected $table = 'mscategory';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>