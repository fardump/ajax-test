<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use Fpdf\Fpdf;
use App\Libraries\PDF_MC_Table;
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
        $startDate = $this->request->getGet('startDate') ? date('Y-m-d', strtotime($this->request->getGet('startDate'))) : null;
        $endDate = $this->request->getGet('endDate') ? date('Y-m-d', strtotime($this->request->getGet('endDate'))) : null;
        $searching = $this->request->getGet('searching') ? strtolower($this->request->getGet('searching')) : null;
        $page = $this->request->getGet('page') ?? 1;
        $limit = $this->request->getGet('limit') ?? 10;
        $offset = ($page - 1) * $limit;

        $filteredUsers = $this->provinceModel->getDataAll($startDate, $endDate, $searching, $limit, $offset);
        $total = $this->provinceModel->getTotalData($startDate, $endDate, $searching);

        return $this->response->setJSON(['success' => 1, 'data' => $filteredUsers, 'total' => $total]);
    }



    public function add()
    {
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try {
            if (empty($nama)) {
                return $this->response->setJSON(['success' => false, 'message' => 'Nama Tidak Boleh Kosong']);
            }

            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'createddate' => date('Y-m-d H:i:s'),
                'createdby' => '1',
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => '1'
            ];
            $this->provinceModel->add($data);
            $this->db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'User Berhasil Dibuat']);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function updateAddress($id)
    {
        $nama = $this->request->getPost('nama');
        $isactive = $this->request->getPost('isactive');
        $this->db->transBegin();
        try {
            $data = [
                'provname' => $nama,
                'isactive' => $isactive,
                'updateddate' => date('Y-m-d H:i:s'),
                'updatedby' => 1,
            ];

            $this->provinceModel->edit($data, $id);
            $this->db->transCommit();
            return $this->response->setJSON(['success' => 'user berhasil diupdate ', 'message' => true,  'Data' => $data]);
        } catch (Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => $e->getMessage(), 'message' => false]);
        }
    }

    public function delete($id)
    {
        $id = $this->request->getPost('provid');
        $this->db->transBegin();
        try {
            $this->provinceModel->delete($id);
            $this->db->transCommit();
            return $this->response->setJSON(['success' => true, 'message' => 'Data Berhasil Dihapus']);
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->response->setJSON(['success' => false, 'message' => 'Data Gagal Dihapus']);
        }
    }

    public function fpdf()
    {
        $pdf = new PDF_MC_Table();
        $pdf->AddPage();
        $pdf->cell(38, 25, '', 1, 0);
        $pdf->SetY(16);
        $pdf->SetX(16);
        $pdf->Image('public/image/logo.jpg', $pdf->GetX(), $pdf->GetY() - 5, 23);
        $pdf->SetY(10);
        $pdf->SetX(48);
        $pdf->SetFont('arial', 'B', 11);
        $pdf->cell(80, 25, 'FORM LAPORAN KELUHAN PELANGGAN', 1, 0);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(20, 6.25, 'Dokumen', 1, 0);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 6.25, '04.1-FRM-MKT', 1, 0);
        $pdf->SetFont('arial', '', 7);
        $pdf->MultiCell(26, 3.1, 'Disetujui oleh : Manager Mutu', 1, 'C');
        $pdf->SetY(16.25);
        $pdf->SetX(128);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(20, 6.25, 'Revisi', 1, 0);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 6.25, '001', 1, 0);
        $pdf->Cell(26, 12.45, '', 1, 0);
        $pdf->SetY(23);
        $pdf->SetX(179);
        $pdf->Image('public/image/image.png',  $pdf->GetX(), $pdf->GetY() - 5, 23);
        $pdf->SetY(22.45);
        $pdf->SetX(128);
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(20, 6.25, 'Tanggal Terbit', 1, 0);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(30, 6.25, '12 october 2022', 1, 1);
        $pdf->SetX(128);
        $pdf->SetFont('arial', '', 9);
        $pdf->Cell(20, 6.25, 'Halaman', 1, 0);
        $pdf->SetFont('arial', '', 8);
        $pdf->Cell(30, 6.25, '1', 1, 0);
        $pdf->Cell(26, 6.25, 'Winna Octavia P. ', 1, 1, 'R');
        $pdf->Ln(3);
        $pdf->SetFont('arial', 'B', 12);
        $pdf->Cell(0, 10, 'LAPORAN KELUHAN PELANGGAN', 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->SetFont('arial', '', 10);
        $pdf->Cell(20, 5, 'No Keluhan', 0, 1);
        $pdf->Cell(20, 5, 'Nama Customer', 0, 1);
        $pdf->Cell(20, 5, 'Nama Pemohon', 0, 1);
        $pdf->Cell(20, 5, 'Telp', 0, 1);
        $pdf->Cell(20, 5, 'Alamat', 0, 0);
        
        $pdf->SetY(53);
        $pdf->SetX(40);
        $pdf->Cell(20, 5, ': 085/MKT-EMIINDO/III/2025', 0, 1);
        $pdf->SetX(40);
        $pdf->Cell(20, 5, ': RUMAH SAKIT UMUM DAERAH KRAMAT JATI', 0, 1);
        $pdf->SetX(40);
        $pdf->Cell(20, 5, ': Firman', 0, 1);
        $pdf->SetX(40);
        $pdf->Cell(20, 5, ': 081338577270', 0, 1);
        $pdf->SetX(40);
        $pdf->Cell(20, 5, ': Jl Raya Inpres No 48', 0, 1);
        
        $pdf->Ln(5);
        $pdf->Cell(190, 10, '', 1, 1);
        $pdf->SetY(83);
        $pdf->Cell(0, 5, 'Deskripsi:', 0, 1);
        $pdf->Cell(0, 5, 'Uap nebulizer tidak keluar, informasi teknisi motor pompa sudah lemah', 0, 1);
        $pdf->Cell(190, 10, '', 1, 1);
        $pdf->SetY(93);
        $pdf->Cell(0, 5, 'Hasil Laporan:', 0, 1);
        $pdf->Cell(0, 5, 'New Data', 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('arial', 'B', '8');
        $pdf->SetWidths(array(10, 50, 20, 20, 30, 20, 40));
        $pdf->SetAligns(array('C', 'C', 'C', 'C', 'C', 'C', 'C'));
        
        $header = ['No', 'Nama Barang', 'UOM', 'Kuantitas', 'Serial number', 'Status', 'Deskripsi'];
        $rows = [
            ['1', 'ELITEXH-INDONESIA MEDICAL NEBULIZER PROMIST 3', 'Unit', '1', 'MN03232A0276', 'Bergaransi', '']
        ];

        $pdf->SetFont('arial', 'B', '8');
        $pdf->Row($header);
        $pdf->SetFont('arial', '', '8');
        $pdf->SetAligns(array('C', 'L', 'L', 'C', 'C', 'C', 'C'));
        foreach ($rows as $row) {
            $pdf->Row($row);
        };
        
        $pdf->setFont('Arial', '', 10);
        $pdf->Ln(5);
        $pdf->Cell(0, 5, 'Jakarta, 10 Maret 2025', 0, 1);
        $pdf->Cell(0, 5, 'Diterima oleh,', 0, 1);
        $pdf->SetY(146);
        $pdf->Image('public/image/ttd.png',  $pdf->GetX(), $pdf->GetY() - 5, 23);
        $pdf->Ln(10);
        $pdf->Cell(0, 5, 'DIAN MEDIANA', 0, 1);
        $pdf->Output('I', 'mycompanyAhcmad.pdf');
        exit;
    }
}
