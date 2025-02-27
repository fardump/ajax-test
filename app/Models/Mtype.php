<?php

namespace App\Models;

use CodeIgniter\Model;

class Mtype extends Model
{
    protected $table = 'mstype';
    protected $primaryKey = 'typeid';
    protected $allowedFields = ['typename', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function getAll()
    {
        return $this->db->table($this->table)->get()->getResultArray();
    }

    public function saveType($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function deleteType($id)
    {
        $this->db->table($this->table)->delete(['typeid' => $id]);
    }

}
?>