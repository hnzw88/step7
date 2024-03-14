<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; 
use App\Models\Sale; 

class SalesController extends Controller
{
    public function purchase(Request $request)
    {
        // リクエストから必要なデータを取得する
        $productId = $request->input('product_id'); 
        $quantity = $request->input('quantity', 1); // 購入する数を代入する もしも”quantity”というデータが送られていない場合は1を代入する
    
        // データベースから対象の商品を検索・取得
        $product = Product::find($productId); 
    
        // 商品が存在しない、または在庫が不足している場合のバリデーションを行うzzz
        if (!$product) {
            return response()->json(['message' => '商品が存在しません'], 404);
        }
        if ($product->stock < $quantity) {
            return response()->json(['message' => '商品が在庫不足です'], 400);
        }
    
        // 在庫を減少させる
        $product->stock -= $quantity; 
        $product->save();
    
       // Salesテーブルに商品IDと購入日時を記録する
        $sale = new Sale([
            'product_id' => $productId,
        ]);
    
        $sale->save();
    
        return response()->json(['message' => '購入成功']);
    }
}