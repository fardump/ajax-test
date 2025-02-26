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

    public function add()
    {

        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');

        if (empty($nama)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Nama Tidak Boleh Kosong']);
        }

        if (empty($isactive)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Isactive Tidak Boleh Kosong']);
        }

        $data = [
            'provname' => $nama,
            'isactive' => $isactive,
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->provinceModel->insert($data)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Ditambahkan']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Ditambahkan']);
        }
    }


    public function edit($id)
    {
        $this->db->transBegin();
        try {
            $nama = $this->request->getPost('nama');
            $isactive = $this->request->getPost('isactive');
            $User = $this->provinceModel->getUser($id);

            if ($nama !== $User['provname'] && $this->provinceModel->validasi($nama)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Username Sudah Ada']);
            }

            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => '1',
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => '1'
            ];

            $this->provinceModel->updateUser($id, $data);


            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                throw new Exception('User Gagal Diupdate');
            }
            $this->db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'User Berhasil Diupdate']);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function update($id, $nama)
    {
        $this->db->transBegin();
        try {
            $nama = $this->request->getPost('nama');
            $isactive = $this->request->getPost('isactive');
            $User = $this->provinceModel->getUser($id);

            if ($nama !== $User['provname'] && $this->provinceModel->validasi($nama)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Username Sudah Ada']);
            }


            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => '1'
            ];


            $this->provinceModel->updateUser($id, $data);


            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                throw new Exception('User Gagal Diupdate');
            }
            $this->db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'User Berhasil Diupdate']);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $id = $this->request->getPost('provid');
        if (empty($id)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'ID Tidak Boleh Kosong']);
        }

        if ($this->provinceModel->delete($id)) {
            return $this->response->setJSON(['status' => 'success', 'message' => 'Data Berhasil Dihapus']);
        } else {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Data Gagal Dihapus']);
        }
    }
}
