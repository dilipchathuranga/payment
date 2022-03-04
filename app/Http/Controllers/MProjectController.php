<?php

namespace App\Http\Controllers;

use App\m_project;
use Illuminate\Http\Request;

class MProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('m_project');
    }
    public function create(){

        $result = m_project::all();

        return DataTables($result)->make(true);
    }
}
