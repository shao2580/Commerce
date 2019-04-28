<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(){
    	echo 111;
    }
    public function doadd($id=0){
    	echo 222;
    }

    public function add(){
    	echo 'add';
    }

    public function lists(){
    	echo 'list';
    }

    public function exit(){
    	echo 'exit';
    }

    public function del(){
    	echo 'del';
    }
}

