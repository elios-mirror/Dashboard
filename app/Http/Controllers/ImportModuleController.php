<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Module;
use GitHub;

class ImportModuleController extends Controller
{

  public function index() {
    return view('import-module');
  }
/*
  public function repository(){
    $repos = GitHub::me()->repositories();

    return view('import-module', ['repos' => $repos]);
  }*/
}
