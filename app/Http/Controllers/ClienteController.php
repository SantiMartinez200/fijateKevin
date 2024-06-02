<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
  public function store(Request $request){
    Cliente::create($request->all());
  }


  public function update()
  {

  }


  public function destroy()
  {

  }
}
