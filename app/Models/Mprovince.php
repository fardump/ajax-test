<?php

namespace App\Models;

use CodeIgniter\Model;

class Mprovince extends Model
{
    protected $table = 'msprovince';
    protected $primaryKey = 'provid';
    protected $allowedFields = ['provname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function store($data)
    {
        $this->db->table($this->table)->insert($data);
    }

    public function getDataAll($startDate = null, $endDate = null, $searching = null, $limit, $offset)
    {
        $builder = $this->db->table('msprovince');
        $builder->orderBy('provid');
    
        if (!empty($startDate)) {
            $builder->where('DATE(createddate) >=', date('Y-m-d', strtotime($startDate)));
        }
        if (!empty($endDate)) {
            $builder->where('DATE(createddate) <=', date('Y-m-d', strtotime($endDate)));
        }
    
        if (!empty($searching)) {
            $builder->like('LOWER(provname)', strtolower($searching));
        }
    
        $builder->limit($limit, $offset);
        return $builder->get()->getResultArray();
    }
    
    public function getTotalData($startDate = null, $endDate = null, $searching = null)
    {
        $builder = $this->db->table('msprovince');
    
        if (!empty($startDate)) {
            $builder->where('DATE(createddate) >=', date('Y-m-d', strtotime($startDate)));
        }
        if (!empty($endDate)) {
            $builder->where('DATE(createddate) <=', date('Y-m-d', strtotime($endDate)));
        }
    
        if (!empty($searching)) {
            $builder->like('LOWER(provname)', strtolower($searching));
        }
    
        return $builder->countAllResults();
    }
    
    public function add($data)
    {
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

    public function getProvName()
    {
        $db = db_connect();
        $builder = $db->query('select * from msprovince where nama');
        return $builder->getResultArray();
    }
}
