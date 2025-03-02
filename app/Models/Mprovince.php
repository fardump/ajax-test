<?php

namespace App\Models;

use CodeIgniter\Model;

class Mprovince extends Model
{
    protected $table = 'msprovince as p';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function store($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function getDataAll()
    {
        $builder = $this->select('*');

        $users = $builder->findAll();   

        return $users;
    }
    
    public function add($data){
        return $this->insert($data);
}

    public function getUser($id)
    {
        return $this->where('provid', $id)->get()->getRowArray();
    }

    public function updateUser($id, $data)
    {
        return $this->update($id, $data);
    }

    public function validasi($nama)
    {

        $builder = $this->where('provname', $nama);
        return $builder->get()->getRowArray();
    }

    public function deleteUser($id)
    {
        return $this->delete(['id' => $id]);
    }

    public function edit($data, $id)
    {
        $this->builder = $this->db->table('msprovince');
        return $this->builder->update($data, ['provid' => $id]);
    }

    
}

?>