<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcity extends Model
{
    protected $table = 'mscity as c';

    public function __construct()
    {
        $this->db = db_connect();
        $this->builder = $this->db->table($this->table);
    }
    protected $allowedFields = ['cityname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];

    public function datatable()
    {
        $this->builder->select('c.cityid, c.cityname, c.isactive')->orderBy('c.cityid', 'asc');
        return $this->builder;
    }
 
    public function store($data)
    {
        return $this->builder->insert($data);
    }

    public function edit($data, $id)
    {
        return $this->builder->update($data, ['cityid' => $id]);
    }

    public function destroy($id)
    {
        return $this->builder->delete(['cityid' => $id]);
    }
}

?>