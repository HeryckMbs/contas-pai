<?php

namespace App\Http\Service;

use App\Http\Resources\GrupoResource;
use App\Http\Resources\UserResource;
use App\Models\Grupo;
use App\Models\GrupoPermissao;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GrupoService
{

    public static function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'permissions' => 'min:1'
        ], [
            'permissions' => 'É necessário escolher pelo menos uma Permissão',
            'name.required' => 'Nome do grupo é obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }
        try {
            DB::beginTransaction();

            $grupo = Grupo::create([
                'nome' => $request->name,
                'slug' => Str::slug($request->name),
            ]);

            foreach($request->permissions as $permissao_id) {
                GrupoPermissao::create([
                    'grupo_id'=> $grupo->id,
                    'permissao_id' => $permissao_id
                ]);
            }

            DB::commit();
            return ['success' => true, 'message' => 'Grupo criado com sucesso!', 'code' => 200];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function getAll()
    {
        $groups = Grupo::paginate(10);
        return [
            'data' => GrupoResource::collection($groups),
            'meta' => [
                'current_page' => $groups->currentPage(),
                'last_page' => $groups->lastPage(),
                'per_page' => $groups->perPage(),
                'total' => $groups->total(),
            ]
        ];
    }

    public static function destroy(int $id ){
        $comum = Grupo::where(['slug' => 'comum'])->first();
        if($id == $comum->id){
            return [ 'data' => [],'success' => false,'message' => 'Não é possível apagar o grupo comum'];
        }
        GrupoPermissao::where('grupo_id',$id)->delete();
        User::where('grupo_id',$id)->update(['grupo_id'=> $comum->id]);
        Grupo::findOrFail($id)->delete();
        return [ 'data' => [],'success' => true,'message' => 'Grupo e permissões associadas excluídas com sucesso'];

    }
    // ignore: use_build_context_synchronously
}
