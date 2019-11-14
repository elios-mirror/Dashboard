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
}
