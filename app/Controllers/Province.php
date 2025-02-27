<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mprovince;
use Exception;

class Province extends BaseController
{

    protected $provinceModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->provinceModel = new Mprovince();
    }
    public function index()
    {
        $data = [
            'title' => 'Province',
            'user' => $this->provinceModel->findAll()
        ];
        return view('master/province/v_province', $data);
    }

    public function getdata()
    {
        $filteredUsers = $this->provinceModel->getDataAll();

        return $this->response->setJSON(['success' => 1 , 'data' => $filteredUsers]);
    }


    public function add()
    {

        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');

        if (empty($nama)) {
            return $this->response->setJSON(['success' => 'success', 'message' => 'Nama Tidak Boleh Kosong']);
        }

        if (empty($isactive)) {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Isactive Tidak Boleh Kosong']);
        }

        $data = [
            'provname' => $nama,
            'isactive' => $isactive,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->provinceModel->add($data)) {
            return $this->response->setJSON(['success' => 'success', 'message' => 'Data Berhasil Ditambahkan']);
        } else {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Data Gagal Ditambahkan']);
        }
    }

    public function update($id)
    {
        $this->db->transBegin();
        try {
            $id = $this->request->getPost('provid');
            $nama = $this->request->getPost('nama');
            $isactive = $this->request->getPost('checkupdate');          
            
            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => '1'
            ];


            $this->provinceModel->update($id, $data);
            $this->db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'User Berhasil Diupdate']);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateAddress($id)
    {
        $id = $this->request->getPost('provid');
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');
        try {
           
            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 1,
            ];
            
            $this->provinceModel->edit($data, $id);
            
            return $this->response->setJSON(['success' => 'Horee ', 'message' => true,  'Data' => $data]);
        }catch(Exception $e){
            return $this->response->setJSON(['success' => $e->getMessage(), 'message' => false]);
        }

        echo json_encode($res);
    }

    public function delete($id)
    {
        $id = $this->request->getPost('provid');
        if (empty($id)) {
            return $this->response->setJSON(['success' => 'error', 'message' => 'ID Tidak Boleh Kosong']);
        }

        if ($this->provinceModel->delete($id)) {
            return $this->response->setJSON(['success' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } else {
            return $this->response->setJSON(['success' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }
}
