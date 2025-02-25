<?php

namespace App\Models;

use CodeIgniter\Model;

class Mekspedition extends Model
{
    protected $table = 'msekspedition';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>