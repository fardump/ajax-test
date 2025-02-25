<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function __construct()
    {
        $this->arrbc = [
            [
                'Master',
                'Warehouse Locator'
            ]
            ];
    }

    public function index()
    {
        $data = [
            'title' => 'Warehouse Locator',
            'breadcrumb' => $this->arrbc,
            'section' => 'Warehouse Locator',
            'akses' => 'Administrator',
        ];
        return view('master/city/v_city', $data);
    }
}
