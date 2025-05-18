<?php

namespace App\Http\Controllers;

use App\Http\Service\CreditCardService;
use Illuminate\Http\Request;

class CreditCardController extends Controller
{
    public function index()
    {
        $page = request()->query('page');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');
        $data = CreditCardService::getAll($itemsPerPage,$page);
        return response()->json($data,200);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = CreditCardService::create($request);
        return response()->json($data,200);
    }

  
    public function show(string $id)
    {
        $data = CreditCardService::findById($id);
        return response()->json($data,200);
    }

    public function getDetails( string $id){
        $data = CreditCardService::getDetails($id);
        return response()->json($data,200);
    }
   
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        $data = CreditCardService::update($request,$id);
        return response()->json($data,200);
    }

  
    public function destroy(string $id)
    {
        
        $data = CreditCardService::destroy($id);
        return response()->json($data,200);
    }
}
