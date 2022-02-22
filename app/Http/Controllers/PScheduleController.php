<?php

namespace App\Http\Controllers;

use App\p_schedule;
use Illuminate\Http\Request;

class PScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('p_schedule');
    }

    public function create(){

        $result = p_schedule::where('status', 'P')->get();

        return DataTables($result)->make(true);

    }
}
