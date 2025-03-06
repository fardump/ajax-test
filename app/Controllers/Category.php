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
            'user' => $this->categoryModel->table()
        ];

        return view('master/category/v_category', $data);
    }

    public function table()
    {
        $data = $this->categoryModel->findAll();
        return $this->response->setJSON($data);
    }

    public function add()
    {
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive') ? 1 : 0;

        if (empty($nama)){
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
        }

        $data = [
            'catname' => $nama,
            'isactive' => $isactive,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->categoryModel->store($data)) {
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

        if ($this->categoryModel->deletecat($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function updateCategory($id){

        $nama = $this->request->getPost('catname');

        $data = [
            'catname' => $nama,
        ];
        
        if ($this->categoryModel->editname($data, $id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Diupdate']);
        }
    }

    public function updateCheck($id){
        $isactie = $this->request->getPost('isactive');

        $data = [
            'isactive' => $isactie,
        ];

        if ($this->categoryModel->updateCheck($id, $data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        }else{
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Diupdate']);
        }
    }

    }

