<?php

namespace App\Models;

use CodeIgniter\Model;

class Muser extends Model
{
    protected $table = 'msuser';
    protected $primaryKey = 'userid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;
}

?>