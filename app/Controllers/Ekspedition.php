<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mekspedition;
use Exception;
use Fpdf\Fpdf;

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
        return $this->response->setJSON($data);
    }

    public function add()
    {
        $expname = $this->request->getVar('expname');
        $isactive = $this->request->getVar('isActive');

        if (empty($expname || $isactive)) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'invalexpid required parameter'
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
    public function deleteExp()
    {
        $expid = $this->request->getVar('expid');

        $this->db->transBegin();
        try {
            if (empty($expid)) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Missing required parameter'
                ]);
            }

            $this->ekspeditionModel->deleteExp($expid);

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

    public function update()
    {
        $expid = $this->request->getPost('expid');
        $isactive = (int) $this->request->getPost('isactive');
        $expname = $this->request->getPost('expname');

        $this->db->transBegin();

        try {
            $data = ['isactive' => $isactive, 'expid' => $expid, 'expname' => $expname];

            $this->ekspeditionModel->updateAc($data, $expid);

            $this->db->transCommit();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Berhasil memperbarui data',
            ]);
        } catch (Exception $e) {
            $this->db->transRollback();

            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Gagal memperbarui data: ' . $e->getMessage(),
            ]);
        }
    }

    public function export()
    {
        $pdf = new Fpdf();

        $pdf->AddPage();
        $pdf->setFont('arial', 'B', 8);
        $height = 20;
        $smHeight = 5;
        $rowHeight = 6;
        $pdf->setXY(5, 10);


        $pdf->Image('public/images/logo.png', 15, 13, 20, 15);
        $pdf->Cell(40, 20, '', 1, 0, 'C');
        $pdf->setFont('arial', 'B', 11);
        $pdf->Cell(85, 20, 'FORM LAPORAN KELUHAN PELANGGAN', 1, 0, 'C');

        $pdf->setFont('arial', 'B', 8);
        $pdf->setXY(130, 10);
        $pdf->Cell(25, $smHeight, 'Dokumen', 1, 0, 'C');
        $pdf->Cell(25, $smHeight, '04.1-FRM-MKT', 1, 1, 'C');

        $pdf->SetXY(130, 15);
        $pdf->Cell(25, $smHeight, 'Revisi', 1, 0, 'C');
        $pdf->Cell(25, $smHeight, '001', 1, 1, 'L');

        $pdf->SetXY(130, 20);
        $pdf->Cell(25, $smHeight, 'Tanggal Terbit', 1, 0, 'C');
        $pdf->Cell(25, $smHeight, '12 October 2022', 1, 1, 'C');

        $pdf->SetXY(130, 25);
        $pdf->Cell(25, $smHeight, 'Halaman', 1, 0, 'C');
        $pdf->Cell(25, $smHeight, '1', 1, 0, 'L');

        $pdf->SetXY(180, 10);
        $pdf->setFont('arial', 'B', 8);
        $pdf->MultiCell(25, 3, 'Disetujui oleh : Manager Mutu',1,'C');
        $pdf->setFont('arial', 'B', 8);
        $pdf->setXY(180, 16);
        $pdf->Image('public/images/ttd2.png', 185,17,10,8);
        $pdf->Cell(25, 9, '', 1, 1, 'C');

        $pdf->setXY(180, 25);
        $pdf->Cell(25, $smHeight, 'Winna Oktavia P.', 1, 1, 'C');


        $pdf->setFont('arial', 'B', 12);
        $pdf->Cell(180, $height, 'Form Laporan Keluhan Pelanggan', 0, 0, 'C');

        $pdf->setFont('arial', '', 10);
        $pdf->setXY(10, 55);
        $pdf->Cell(50, $rowHeight, 'No Keluhan', 0, 0, 'L');
        $pdf->Cell(100, $rowHeight, ': 085/MKT-EMIINDO/III/2025', 0, 1, 'L');

        $pdf->Cell(50, $rowHeight, 'Nama Customer', 0, 0, 'L');
        $pdf->Cell(100, $rowHeight, ': RUMAH SAKIT UMUM DAERAH KRAMAT JATI', 0, 1, 'L');

        $pdf->Cell(50, $rowHeight, 'Nama Pemohon', 0, 0, 'L');
        $pdf->Cell(100, $rowHeight, ': Firman', 0, 1, 'L');

        $pdf->Cell(50, $rowHeight, 'Telp', 0, 0, 'L');
        $pdf->Cell(100, $rowHeight, ': 08133577270', 0, 1, 'L');

        $pdf->Cell(50, $rowHeight, 'Alamat', 0, 0, 'L');
        $pdf->Cell(100, $rowHeight, ': Jl Raya Inpres No 48', 0, 1, 'L');

        $pdf->SetXY(5, 90);
        $pdf->Cell(200, 10, 'Deskripsi:', 1, 1, 'L');
        $pdf->SetXY(5, 100);
        $pdf->MultiCell(200, 8, 'Uap nebulizer tidak keluar, informasi teknisi motor sudah lemah', 1, 'L');

        $pdf->SetXY(5, 108);
        $pdf->MultiCell(200, 4, 'Hasil Laporan : 
New Data', 1, 'L');

        $pdf->setXY(5, 124);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C');
        $pdf->Cell(50, 7, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 7, 'UOM', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Kuantitas', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Serial Number', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Status', 1, 0, 'C');
        $pdf->Cell(30, 7, 'Deskripsi', 1, 1, 'C');

        $pdf->setFont('arial', '', 8);
        $pdf->setXY(5, 131);
        $pdf->Cell(10, 10, '1', 1, 0, 'C');
        $pdf->MultiCell(50, 5, 'Elitech - INDONESIA MEDICAL NEBULIZER PROMIST 3', 1, 'L');
        $pdf->setXY(65, 131);
        $pdf->Cell(20, 10, 'Unit', 1, 0, 'L');
        $pdf->Cell(30, 10, '1', 1, 0, 'C');
        $pdf->Cell(30, 10, 'MN009324212', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Bergaransi', 1, 0, 'C');
        $pdf->Cell(30, 10, '', 1, 0, 'C');

        $pdf->setFont('arial', '', 10);
        $pdf->setXY(10, 150);

        $pdf->Cell(30, 7, 'Jakarta, 10 Maret 2025', 0, 1, 'C');
        $pdf->Cell(30, 7, 'Diterima Oleh,', 0, 0, 'C');
        $pdf->Image('public/images/ttd.png', 10,165,30,30);
        $pdf->Cell(30, 7, '', 0, 1, 'C');
        $pdf->Cell(30, 70, 'DIAN MEDIANA', 0, 0, 'C');

        // $pdf->Cell(30, 7, 'Jakarta, 10 Maret 2025', 0, 0, 'C');
        // $pdf->Cell(30, 7, 'Jakarta, 10 Maret 2025', 0, 0, 'C');









        $pdf->Output();
        exit();
    }
}
