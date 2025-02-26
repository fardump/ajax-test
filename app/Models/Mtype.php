<?php

namespace App\Models;

use CodeIgniter\Model;

class Mtype extends Model
{
    protected $table = 'mstype';
    protected $primaryKey = 'typeid';
    protected $allowedFields = ['typename', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function saveType($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function deleteType($data)
    {
        $this->db->table($this->table)->where('typename', $data['typename'])->update($data);
    }

    public function find($typeid = null)
    {
        return $this->where(['typeid' => $typeid])->first();
    }
}

?>