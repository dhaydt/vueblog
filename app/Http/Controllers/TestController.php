<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller{
    
    public function method()
    {
        return response()->json([
            'msg'   =>  'hanya mengembalikan json'
        ]);
    }
}