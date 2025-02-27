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
        $data = $this->ekspeditionModel->findAll();
        return $this->response->setJSON($data);    }

    public function add()
{
    $expname = $this->request->getVar('expname');
    $isactive = $this->request->getVar('isActive');

    if (empty($expname || $isactive)) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'invalid required parameter'
        ])->setContentType('application/json');  // Add content type
    }

    $data = [
        'createddate' => date('Y-m-d H:i:s'),
        'createdbty' => '1',
        'expname' => $expname,
        'isactive' => $isactive,
        'updateddate' => date('Y-m-d H:i:s'),
        'updatedby' => '1',
    ];

    try {
        if ($this->ekspeditionModel->saveData($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data berhasil disimpan',
                'data' => $data
            ])->setContentType('application/json');
        }
        
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Data Gagal disimpan'
        ])->setContentType('application/json');

    } catch (Exception $e) {
        return $this->response->setJSON([
            'status' => 'error',
            'message' => $e->getMessage()
        ])->setContentType('application/json');
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
