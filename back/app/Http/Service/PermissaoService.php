<?php

namespace App\Http\Service;

use App\Http\Resources\PermissaoResource;
use App\Http\Resources\UserResource;
use App\Models\GrupoPermissao;
use App\Models\Permissao;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PermissaoService
{

    public static function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            
            'name' => 'required',
        ], [
            'name.required' => 'Nome obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }
        try {
            DB::beginTransaction();

            $permissao = Permissao::create([
                'nome' => $request->name,
                'slug' => Str::slug($request->name,'_'),
            ]);
            // foreach($request->grupo as $grupo) {
            //     GrupoPermissao::create([
            //         'grupo_id'=> $grupo,
            //         'permissao_id' => $permissao->id
            //     ]);
            // }
            

            DB::commit();
            return ['success' => true, 'message' => 'Permissão criado com sucesso!', 'code' => 200];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function getAll()
    {
        $users = Permissao::paginate(10);
        return [
            'data' => PermissaoResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ];
    }

    public static function destroy(int $id){
        try {
            GrupoPermissao::where('permissao_id',$id)->delete();
            Permissao::findOrFail($id)->delete();
            return  ['success'=> true,'message' => 'Permissão excluída com sucesso!'];
        } catch (\Exception $e) {
            return  ['success'=> false,'message' => 'Não foi possível excluir a permissão!'];
        }
    }

    // ignore: use_build_context_synchronously
}
