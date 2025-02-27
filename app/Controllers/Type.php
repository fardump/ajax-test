<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mtype;
use Exception;

class Type extends BaseController
{

    protected $typeModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->typeModel = new Mtype();
    }
    public function index()
    {
        $data = [
            'title' => 'Type',
            'type' => $this->typeModel->findAll()
        ];
        return view('master/type/v_type', $data);
    }

    public function save()
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'typename' => 'required',
            'isactive' => 'required',
        ]);

        $data = [
            'typename' => $this->request->getPost('typename'),
            'isactive' => $this->request->getPost('isactive') == '1' ? '1' : '0',
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1',
        ];
        $this->typeModel->saveType($data);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan!',
            'data' => $data,
        ]);
    }
    public function delete($id)
    {
        $deleted = $this->typeModel->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Data Gagal Dihapus'
            ]);
        }
    }
    public function loadTable()
    {
        $data = $this->typeModel->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }

    public function update()
    {

        $typeid = $this->request->getPost('typeid');
        $typename = $this->request->getPost('typename');
        $isactive = $this->request->getPost('isactive');

        $data = [
            'typename' => $typename,
            'isactive' => $isactive == '1' ? '1' : '0',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1',
        ];

        if ($this->typeModel->update($typeid, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Type updated successfully']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Failed to update type']);
        }
    }
 }

