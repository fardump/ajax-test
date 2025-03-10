<?php

namespace App\Models;

use CodeIgniter\Model;

class Mcategory extends Model
{
    protected $table = 'mscategory';
    protected $primaryKey = 'catid';
    protected $allowedFields = ['catname', 'createddate', 'createdby', 'updateddate', 'updatedby', 'isactive'];
    protected $useTimestamps = false;

    public function table()
    {
        return $this->findAll();
    }

    public function datatable($perPage, $startdate, $enddate, $search, $page)
    {
        $builder = $this->db->table($this->table);

        // Filter Kalender
        if (!empty($startdate)) {
            $builder->where('DATE(createddate) >=', $startdate);
        }
        if (!empty($enddate)) {
            $builder->where('DATE(createddate) <=', $enddate);
        }

        // Filter Search
        if (!empty($search)) {
            $builder->like('LOWER(catname)', strtolower($search));
        }

        // Hitung total data untuk paginasi
        $totalResults = $builder->countAllResults(false); 

        // Paginasi
        $offset = ($page - 1) * $perPage;
        $data = $builder->orderBy('createddate', 'DESC')
            ->limit($perPage, $offset)
            ->get()
            ->getResultArray();

        return [
            'data' => $data,
            'total' => $totalResults,
        ];
    }


    public function getPaginatedData($perPage)
    {
        return $this->orderBy('createddate', 'DESC')->paginate($perPage);
    }

    public function search($search)
    {
        return $this->like('catname', $search);
    }

    public function store($data)
    {
        return $this->insert($data);
    }

    public function editname($data, $id)
    {
        return $this->update($id, $data);
    }

    public function deletecat($id)
    {
        return $this->delete($id);
    }

    public function updateCheck($catid, $data)
    {
        return $this->update($catid, $data);
    }
}
