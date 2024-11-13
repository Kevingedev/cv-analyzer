<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;

class CvController extends Controller
{
    //
    public function index(){


        $positions = Position::all();


        return view('document', compact('positions'));
    }
}
