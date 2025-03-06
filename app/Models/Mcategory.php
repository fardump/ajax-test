<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcategory extends Model
{
    protected $table = 'mscategory';
    protected $primaryKey = 'catid';
    protected $allowedFields = ['catname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function table(){
        return $this->findAll();
    }

    public function store($data){
        return $this->insert($data);
    }

    public function editname($data, $id){
        return $this->update($id, $data);
    }

    public function deletecat($id){
        return $this->delete($id);
    }

    public function updateCheck($catid, $data){
        return $this->update($catid, $data);
    }

}
?>