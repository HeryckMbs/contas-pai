<?php

namespace App\Http\Controllers;

use App\Http\Service\PermissaoService;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\Permissao;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class PermissaoController extends Controller
{
    public function index()
    {
       $data = PermissaoService::getAll();
       return response()->json($data,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $grupos = Grupo::all();
        $gruposSelecionados = [];
        return view("permissao.form",compact('grupos','gruposSelecionados'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = PermissaoService::store($request);
        return response()->json($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
  
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $grupos = Grupo::all();
        $permissao = Permissao::findOrFail($id);
        $gruposSelecionados = $permissao->gruposId->pluck('grupo_id')->toArray() ??[];
        return view("permissao.form",compact('grupos','permissao','gruposSelecionados'));

        } catch (\Exception $e) {
            return back()->with('messages', ['error' => ['Não foi possível editar a permissão!']]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PermissaoService::destroy($id);
        return response()->json($data);
      
    }
}
