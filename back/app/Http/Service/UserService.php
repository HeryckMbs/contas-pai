<?php

namespace App\Http\Service;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserService
{

    public static function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
            'name' => 'required',
        ], [
            'email.required' => 'Email obrigatório',
            'password.required' => 'Senha obrigatória',
            'name.required' => 'Nome obrigatório',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }
        try {
            DB::beginTransaction();

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);

            User::create($input);

            DB::commit();
            return ['success' => true, 'message' => 'Usuário criado com sucesso!', 'code' => 200];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function getAll()
    {
        $users = User::paginate(10);
        return [
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ]
        ];
    }

    // ignore: use_build_context_synchronously
}
