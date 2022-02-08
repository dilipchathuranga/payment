<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function bill_session(Request $request){

        Session::put(['bill_session' => $request->session]);

    }

    
    public function get_session(){

        $result = array();

        $result['bill_session'] = Session::get('bill_session');

        return response()->json($result);

    }
}
