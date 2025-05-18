<?php 
namespace App\Http\Service;

use App\Models\ShoppingCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ShoppingCategoryService
{
    public static function getAll()
    {
       $categories = ShoppingCategory::select(['id','name'])->get();
       return ['data' => $categories];
    }

    public static function create(Request $request)
    {

        $validator = Validator::make($request->all(), [

    
        ], [
     
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
           

            DB::commit();
            return ['success' => true, 'message' => 'Conta a pagar criada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }

    public static function destroy(int $id){
      
    }
    public static function findById(int $id)
    {

        try {

        
            return ['success' => true, 'message' => '','data' => '', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $id, 'code' => $e->getCode()];
        }
    }

    public static function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [

    
        ], [
 
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->getMessageBag()], 403);
        }

        try {
            DB::beginTransaction();

     
            DB::commit();
            return ['success' => true, 'message' => 'Categoria atulizada com sucesso!', 'code' => 200];
        } catch (Exception $e) {
            DB::rollBack();
            return ['success' => false, 'message' => $e->getMessage(), 'request' => $request, 'code' => $e->getCode()];
        }
    }
}
