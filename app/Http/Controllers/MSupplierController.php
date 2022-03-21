<?php

namespace App\Http\Controllers;

use App\m_supplier;
use Illuminate\Http\Request;

class MSupplierController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('m_supplier');
    }
    public function create(){

        $result = m_supplier::all();

        return DataTables($result)->make(true);
    }

}
