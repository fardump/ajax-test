<?php

namespace App\Models;

use CodeIgniter\Model;

class Mekspedition extends Model
{
    protected $table = 'msexpedition';
    protected $primaryKey = 'expid';
    protected $allowedFields = ['expname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;


    public function saveData($data)
    {
        return $this->insert($data);
    }


    public function deleteExp($id)
    {
        return $this->where('expid', $id)->delete();
    }

    public function findData()
    {
        return $this->orderBy('expid', 'ASC')
            ->findAll();
    }
}
