<?php

namespace App\Http\Controllers;

use App\Http\Service\BillToRecieveService;
use Illuminate\Http\Request;

class BillToRecieveController extends Controller
{
     
    public function index()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');

        $data = BillToRecieveService::getAll($mes,$ano,$itemsPerPage,$page);
        return response()->json($data,200);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = BillToRecieveService::create($request);
        return response()->json($data,200);
    }

  
    public function show(string $id)
    {
        $data = BillToRecieveService::findById($id);
        return response()->json($data,200);
    }

   
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        $data = BillToRecieveService::update($request,$id);
        return response()->json($data,200);
    }

       
    public function receive(Request $request, string $id)
    {
        $data = BillToRecieveService::receive($request,$id);
        return response()->json($data,200);
    }


  
    public function destroy(string $id)
    {
        
        $data = BillToRecieveService::destroy($id);
        return response()->json($data,200);
    }
}
