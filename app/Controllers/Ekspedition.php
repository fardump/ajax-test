<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Mekspedition;
use Exception;

class Ekspedition extends BaseController {

    protected $ekspeditionModel;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->ekspeditionModel = new Mekspedition();
    }
    public function index(){
$data =[
    'title' => 'Ekspedition',
];
return view('master/ekspedition/v_ekspedition', $data);
    }
}
?>