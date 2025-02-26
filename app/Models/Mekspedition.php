<?php

namespace App\Models;

use CodeIgniter\Model;

class Mekspedition extends Model
{
    protected $table = 'msekspedition';
    protected $primaryKey = 'expid';
    protected $allowedFields = ['expname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function addData($data)
    {
        return $this->insert($data);
    }


    public function deleteExp($id)
    {
        return $this->where('expid', $id)->delete();
    }        

}
