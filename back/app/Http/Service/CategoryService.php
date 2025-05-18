<?php

namespace App\Http\Service;

use App\Http\Resources\BillToPayResource;
use App\Http\Resources\CategoryResource;
use App\Models\BillToPay;
use App\Models\Categoria;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryService
{
    public static function getAll($type = '', $itemsPerPage = 10, $page = 1)
    {

        $categories = Category::when($type != '', function ($query) use ($type) {
            $query->where('type', '=', $type);
        })
            ->paginate($itemsPerPage, ['*'], 'page', $page);

        return [
            'data' => CategoryResource::collection($categories),
            'meta' => [
                'current_page' => $categories->currentPage(),
                'last_page' => $categories->lastPage(),
                'per_page' => $categories->perPage(),
                'total' => $categories->total(),
            ]
        ];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'type' => 'required',

        ], [
            'name.required' => 'Nome da categoria é obrigatório',
            'type.required' => 'Tipo da categoria é obrigatório',


        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            Category::create([
                'name' => $request->name,
                'type' => $request->type
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Categoria criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }


    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'type' => 'required',

        ], [
            'name.required' => 'Nome da categoria é obrigatório',
            'type.required' => 'Tipo da categoria é obrigatório',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

            Category::where('id', '=', $id)->update([
                'name' => $request->name,
                'type' => $request->type
            ]);

            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }


    public static function destroy(int $id)
    {

        Category::where('id', '=', $id)->delete();
        return ['data' => [], 'success' => true, 'message' => 'Categoria excluída com sucesso'];
    }
    public static function findById(int $id)
    {

        try {

            $category = Category::find($id);

            return ['success' => true, 'message' => '', 'data' => $category, 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }
}
