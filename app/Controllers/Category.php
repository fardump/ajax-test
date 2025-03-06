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
        ];

        return view('master/category/v_category', $data);
    }

    public function table()
{
    $page = $this->request->getVar('page') ?? 1;

    $data = $this->categoryModel->getPaginatedData(5); 
    $pager = $this->categoryModel->pager->makeLinks($page, 5, $this->categoryModel->countAllResults(), 'category_pagination');

    return $this->response->setJSON([
        'data' => $data,
        'pager' => $pager,
    ]);
}



    public function add()
    {
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive') ? 1 : 0;

        $this->db->transbegin();

        try {

            if (empty($nama)) {
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

            $this->categoryModel->store($data);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Ditambahkan']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Ditambahkan']);
        }
    }

    public function delete()
    {
        $id = $this->request->getPost('id');

        $this->db->transbegin();

        try {
            $this->categoryModel->delete($id);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function updateCategory($id)
    {

        $nama = $this->request->getPost('catname');

        $this->db->transbegin();

        try {

            if (empty($nama)) {
                return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
            };

            $data = [
                'catname' => $nama
            ];

            $this->categoryModel->editname($data, $id);
            $this->db->transcommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            $this->db->transrollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal DiUpdate']);
        }
    }

    public function updateCheck($id)
    {
        $isactie = $this->request->getPost('isactive');

        $this->db->transBegin();

        try {

            $data = [
                'isactive' => $isactie,
            ];

            $this->categoryModel->updateCheck($id, $data);
            $this->db->transCommit();
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Diupdate']);
        } catch (\Throwable $th) {
            $this->db->transRollback();
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Diupdate']);
        }
    }
}
