<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Muser;
use Fpdf\Fpdf;
use App\Libraries\PDF_MC_Table;


use Exception;

class User extends BaseController
{

    protected $userModel;
    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->userModel = new Muser();
    }
    public function index()
    {

        $data = [
            'title' => 'User',
            'user' => $this->userModel->findAll()
        ];
        return view('master/user/v_user', $data);
    }

    public function deleteUsers($id)
    {
        $deleted = $this->userModel->delete($id);

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

    public function add()
    {

        $Data = [
            'username' => $this->request->getPost('username'),
            'isactive' => $this->request->getPost('isactive'),
            'createddate' => date('Y-m-d H:i:s'),
            'createdby' => '1',
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        $this->userModel->insert($Data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Data berhasil ditambahkan!',
            'data' => $Data,
        ]);
    }
    public function loadTable()
    {
        $data = $this->userModel->findAll();
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $data
        ]);
    }
    public function update()
    {

        $userid = $this->request->getPost('userid');
        $username = $this->request->getPost('username');
        $isactive = $this->request->getPost('isactive');

        $data = [
            'username' => $username,
            'isactive' => $isactive,
            'updateddate' => date('Y-m-d H:i:s'),
            'updatedby' => '1'
        ];

        if ($this->userModel->update($userid, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Data has been saved '
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update username'
            ]);
        }
    }
    public function exportPDF()
    {

        // Buat objek PDF
        $pdf = new PDF_MC_TABLE();
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 10);

        $pdf->Cell(40, 20, 'Logo', 1,         0,         'C');

        $pdf->Image('public/image/logo.jpg', 17, 12.5, 25, 15);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(75, 20, 'FORM LAPORAN KELUHAN PELANGGAN', 1,         0,         'C');

        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(20, 5, 'Dokumen', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 5, '04.1-FRM-MKT', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 6);
        $pdf->MultiCell(30, 2.5, 'Disetujui oleh :
Manager Mutu', 1, 'C');

        $pdf->Image('public/image/image.png', 175, 16, 19, 9);

        $pdf->setX(125);
        $pdf->Cell(20, 5, 'Revisi', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 5, '001', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 6);
        $pdf->Cell(30, 10, '', 1, 'C');

        $pdf->SetFont('Arial', '', 6);
        $pdf->setY(20);
        $pdf->setX(125);
        $pdf->Cell(20, 5, 'Tanggal Terbit', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 5, '12 October 2022', 1, 1, 'L');

        // $pdf->Cell(30, 5, '', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 6);
        $pdf->setX(125);
        $pdf->Cell(20, 5, 'Halaman', 1, 0, 'L');


        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(25, 5, '1', 1, 0, 'L');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(30, 5, 'Winna Oktavia P.', 1, 1, 'C');

        $pdf->Ln(2);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Laporan Keluhan Pelanggan', 0, 0, 'C');
        $pdf->Ln(17);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(30, 5, 'No Keluhan', 0, 0, 'L');
        $pdf->Cell(5, 5, ':', 0, 0, 'L');
        $pdf->Cell(30, 5, '085/MKT-EMIINDO/III/2025 ', 0, 1, '');
        $pdf->Cell(30, 5, 'Nama Customer', 0, 0, 'L');
        $pdf->Cell(5, 5, ': ', 0, 0, 'L');
        $pdf->Cell(30, 5, 'RUMAH SAKIT UMUM DAERAH KRAMAT JATI ', 0, 1, '');
        $pdf->Cell(30, 5, 'Nama Pemohon', 0, 0, 'L');
        $pdf->Cell(5, 5, ': ', 0, 0, 'L');
        $pdf->Cell(30, 5, 'Firman ', 0, 1, '');
        $pdf->Cell(30, 5, 'Telp', 0, 0, 'L');

        $pdf->Cell(5, 5, ': ', 0, 0, 'L');
        $pdf->Cell(30, 5, '081338577270 ', 0, 1, '');
        $pdf->Cell(30, 5, 'Alamat', 0, 0, 'L');
        $pdf->Cell(5, 5, ': ', 0, 0, 'L');
        $pdf->Cell(30, 5, 'Jl Raya Inpres No 48 ', 0, 1, '');

        $pdf->ln(5);

        $pdf->MultiCell(190, 5, 'Deskripsi: 
Uap nebulizer tidak keluar, informasi teknisi motor pompa sudah lemah', 1, 'L');
        $pdf->MultiCell(190, 5, 'Hasil Laporan : 
New Data', 1, 'L');


        $pdf->ln(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama Barang', 1, 0, 'C');
        $pdf->Cell(20, 6, 'UOM', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Kuantitas', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Serial Number', 1, 0, 'C');
        $pdf->Cell(20, 6, 'Status', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Deskripsi', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(10, 8, '1', 1, 0, 'L');
        $pdf->Cell(50, 8, 'ELITECH ', 1, 0, 'L');
        $pdf->Cell(20, 8, 'UOM', 1, 0, 'L');
        $pdf->Cell(20, 8, 'Kuantitas', 1, 0, 'L');
        $pdf->Cell(35, 8, 'Serial number', 1, 0, 'L');
        $pdf->Cell(20, 8, 'Status', 1, 0, 'L');
        $pdf->Cell(35, 8, '', 1, 1, 'L');

        $pdf->ln(3);
        $pdf->setX(15);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(10, 4, 'Jakarta, 10 Maret 2025', 0, 1, 'L');

        $pdf->ln(2);
        $pdf->setX(22.5);
        $pdf->Cell(10, 4, 'Diterima oleh,', 0, 1, 'L');

        $pdf->Image('public/image/ttd.png', 19, 132, 25, 15);

        $pdf->setY(150);
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(47, 4, 'DIAN MEDIANA', 0, 1, 'C');

        $pdf->Output();
        exit();
    }
}
