<?php

namespace App\Http\Controllers;

use App\Http\Service\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $typeFilter = request()->query('type');
        $itemsPerPage = request()->query('itemsPerPage');
        $page = request()->query('page');
        $data = CategoryService::getAll($typeFilter,$itemsPerPage,$page);
        return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = CategoryService::create($request);
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = CategoryService::findById($id);
        return response()->json($data,200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = CategoryService::update($request,$id);
        return response()->json($data,200);
    }

 
    public function destroy(string $id)
    {
        $data = CategoryService::destroy($id);
        return response()->json($data);
    }
}
