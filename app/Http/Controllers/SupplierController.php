<?php

namespace App\Http\Controllers;

use App\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('supplier');
    }
    public function create(){

        $result = supplier::all();

        return DataTables($result)->make(true);
    }
}
