<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mekspedition;
use Exception;

class Ekspedition extends BaseController
{

    protected $ekspeditionModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->ekspeditionModel = new Mekspedition();
    }
    public function index()
    {
        $data = [
            'title' => 'Ekspedition',
        ];
        return view('master/ekspedition/v_ekspedition', $data);
    }

    public function getData()
    {
        return $this->response->setJSON($this->ekspeditionModel->getData());
    }

    public function add()
    {
        try {
            $this->db->transBegin();
            $expId = $this->request->getPost('id');
            $expName = $this->request->getPost('expName');
            $createdBy = $this->request->getPost('usernm');
            $isActive = $this->request->getPost('checkboxVal');

            if (empty($expId || $expName || $createdBy || $isActive)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Invalid Required Parameter',
                ]);
            }

            $data = [
                'createdby' => $createdBy,
                'expname' => $expName,
                'isactive' => $isActive,
            ];

            $this->ekspeditionModel->addData($expId, $data);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Gagal Disimpan'
                ]);
            }

            $this->db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Berhasil Disimpan'
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function delete()
    {
        $this->db->transBegin();
        try {
            $id = $this->request->getPost('expid');

            $expname = $this->ekspeditionModel->find($id);

            if (!$expname) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Ekspedition not found'
                ]);
            }

            $this->ekspeditionModel->delete($id);

            if ($this->db->transStatus() === FALSE) {
                $this->db->transRollback();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Gagal Dihapus..'
                ]);
            }
            $this->db->transCommit();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data Berhasil Dihapus'
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
