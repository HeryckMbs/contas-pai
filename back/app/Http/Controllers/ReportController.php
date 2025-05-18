<?php

namespace App\Http\Controllers;

use App\Http\Service\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $ano = request()->query('ano') ;
        $mes = request()->query('mes');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');
        
        $data = ReportService::getAll($mes,$ano,$itemsPerPage,$page);
        return response()->json($data,200);
    }

    
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $data = ReportService::create($request);
        return response()->json($data,200);
    }

  
    public function show(string $id)
    {
        $data = ReportService::findById($id);
        return response()->json($data,200);
    }

   
    public function edit(string $id)
    {
        //
    }

    
    
    public function update(Request $request, string $id)
    {
        $data = ReportService::update($request,$id);
        return response()->json($data,200);
    }

  
    public function destroy(string $id)
    {
        
        $data = ReportService::destroy($id);
        return response()->json($data,200);
    }
}
