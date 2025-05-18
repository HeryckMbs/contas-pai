<?php

namespace App\Http\Controllers;

use App\Http\Service\ShoppingService;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function index()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');
        $data = ShoppingService::getAll($mes,$ano,$itemsPerPage,$page);
        return response()->json($data,200);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = ShoppingService::create($request);
        return response()->json($data,200);
    }

  
    public function show(string $id)
    {
        $data = ShoppingService::findById($id);
        return response()->json($data,200);
    }

   
    public function edit(string $id)
    {
        //
    }
    public function payShopping(Request $request, string $id)
    {
        $data = ShoppingService::payShopping($request,$id);
        return response()->json($data,200);    }
    
    
    public function update(Request $request, string $id)
    {
        $data = ShoppingService::update($request,$id);
        return response()->json($data,200);
    }

  
    public function destroy(string $id)
    {
        
        $data = ShoppingService::destroy($id);
        return response()->json($data,200);
    }
}
