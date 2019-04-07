<?php

namespace App\Http\Controllers;

use App\Module;
use Illuminate\Http\Request;

class StoreController extends Controller
{
  public function index(Request $request)
  {
    $modules = Module::paginate();
    return $modules;
  }

  public function search(Request $request)
  {
    $search = $request->get('q');
    if (!$search) {
      abort(400, "Missing 'q' query param ");
    }
    $modules = Module::where('name', 'LIKE', '%' . $search . '%')->orWhere('title', 'LIKE',  '%' . $search . '%')->paginate();
    return $modules;
  }
}
