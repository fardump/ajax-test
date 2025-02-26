<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mcategory;
use Exception;

class Category extends BaseController
{

    protected $categoryModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->categoryModel = new Mcategory();
    }
    public function index()
    {
        $data = [
            'title' => 'Category',
            'user' => $this->categoryModel->findAll()
        ];
        return view('master/category/v_category', $data);
    }

    public function add()
    {
        
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');

        if (empty($nama)){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
        }

        if (empty($isactive)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Isactive Tidak Boleh Kosong']);
        }

        $data = [
            'catname' => $nama,
            'isactive' => $isactive,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->categoryModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Ditambahkan']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Ditambahkan']);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');
        if (empty($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID Tidak Boleh Kosong']);
        }

        if ($this->categoryModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function edit($id)
    {
        $data = $this->categoryModel->find($id);
        if (empty($data)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Tidak Ditemukan']);
        }

        return $this->response->setJSON(['status' => 'success', 'data' => $data]);
    }

    public function update()
    {
        $id = $this->request->getPost('catid');
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');

        if (empty($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID Tidak Boleh Kosong']);
        }

        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
        }

        if (empty($isactive)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Isactive Tidak Boleh Kosong']);
        }

        $data = [
            'catname' => $nama,
            'isactive' => $isactive,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->categoryModel->update($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Diupdate']);
        }
    }
}
