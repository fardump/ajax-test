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

    public function datatable($perPage = 10, $page = 1, $fromdate = null, $todate = null, $search = null)
    {
        $offset = ($page - 1) * $perPage;
        
        $this->builder->select('c.*')
            ->orderBy('c.cityid', 'asc');

        if (!empty($fromdate) && !empty($todate)) {
            $this->builder->where('c.createddate >=', $fromdate);
            $this->builder->where('c.createddate <=', $todate);
        }

        if (!empty($search)) {
            $this->builder->like('LOWER(c.cityname)', strtolower($search));
        }

        $totalQuery = clone $this->builder;
        $total = $totalQuery->countAllResults(false);

        $this->builder->limit($perPage, $offset);
        $data = $this->builder->get()->getResult();

        return [
            'data' => $data,
            'from_date' => $fromdate,
            'to_date' => $todate,
            'total' => $total,
            'per_page' => $perPage,
            'current_page' => $page,
            'total_pages' => ceil($total / $perPage)
        ];
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

    public function getImageUrl($id)
    {
        $this->builder->select('c.image')
            ->where('c.cityid', $id);
        return $this->builder->get()->getRow();
    }
}
