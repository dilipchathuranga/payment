<?php

namespace App\Http\Controllers;

use App\project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('project');
    }
    public function create(){

        $result = project::all();

        return DataTables($result)->make(true);
    }
}
