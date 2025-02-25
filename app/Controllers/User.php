<?php 
namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\Controller\database;
use App\Models;
use App\Models\Muser;
use Exception;

class User extends BaseController {

    protected $userModel;
    public function __construct(){
        $this->db = \Config\Database::connect();
        $this->userModel = new Muser();
    }
    public function index(){
$data =[
    'title' => 'user',
];
return view('master/user/v_user', $data);
    }
}
?>