<?php

namespace App\Models;

use CodeIgniter\Model;

class Mekspedition extends Model
{
    protected $table = 'msexpedition';
    protected $primaryKey = 'expid';
    protected $allowedFields = ['expid', 'expname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;


    public function saveData($data)
    {
        return $this->insert($data);
    }


    public function deleteExp($expid)
    {
        return $this->where('expid', $expid)->delete();
    }

    public function findData()
    {
        return $this->orderBy('expid', 'ASC')
            ->findAll();
    }

    public function updateAc($data, $expid)
    {
        return $this->update($data, ['expid' => $expid]);
    }
}
