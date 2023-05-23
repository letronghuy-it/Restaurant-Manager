<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
        return view('admin.page.khu_vuc.index');
    }

    public function viewTaiKhoan(){
        return view('admin.page.Tai_Khoan.index');
    }
}


