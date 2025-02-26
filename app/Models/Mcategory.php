<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcategory extends Model
{
    protected $table = 'mscategory';
    protected $primaryKey = 'catid';
    protected $allowedFields = ['catname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>