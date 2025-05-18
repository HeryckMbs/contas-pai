<?php

namespace App\Http\Controllers;

use App\Http\Service\UserService;
use App\Models\Integrante;
use App\Models\Membro;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
   
    public function index()
    {
        $data = UserService::getAll();
        return response()->json($data,200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function store(Request $request){
     
      $result =  UserService::store($request);
      return response()->json($result,$result['code']);
    }

        // ignore: use_build_context_synchronously
}
