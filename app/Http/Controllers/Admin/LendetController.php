<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LendetController extends Controller
{
    public function canvas_collision()
    {
        return view('admin.lendet.canvas-collision');
    }      
    public function pixijs_hanoi()
    {
        return view('admin.lendet.pixijs-hanoi');
    }  
    public function pixijs_tictactoe()
    {
        return view('admin.lendet.pixijs-tictactoe');
    }     
}