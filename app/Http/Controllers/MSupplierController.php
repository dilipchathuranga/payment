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

    public function show($bp_no){

        $result = m_supplier::where('bp_no',$bp_no)->get();

        return response()->json($result);

    }

}
