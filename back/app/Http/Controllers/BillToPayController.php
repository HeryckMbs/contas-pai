<?php

namespace App\Http\Controllers;

use App\Http\Service\BillToPayService;
use Illuminate\Http\Request;

class BillToPayController extends Controller
{
   
    public function index()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');

        $data = BillToPayService::getAll($mes,$ano,$itemsPerPage,$page);
        return response()->json($data,200);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
       try{
 $data = BillToPayService::create($request);
        return response()->json($data,200);
       }catch(\Exception $e){
        return response()->json([],500);

       }
    }

  
    public function show(string $id)
    {
        $data = BillToPayService::findById($id);
        return response()->json($data,200);
    }

   
    public function edit(string $id)
    {
        //
    }

    
    public function update(Request $request, string $id)
    {
        $data = BillToPayService::update($request,$id);
        return response()->json($data,200);
    }

    public function pay(Request $request, string $id)
    {
        $data = BillToPayService::pay($request,$id);
        return response()->json($data,200);
    }


  
    public function destroy(string $id)
    {
        
        $data = BillToPayService::destroy($id);
        return response()->json($data,200);
    }
}
