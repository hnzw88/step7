<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    //可変項目
    protected $fillable = [
        'company_id',
        'product_name',
        'price',
        'stock',
        'comment',
        'img_path',
    ];

    public function createProduct($request, $img_path){
        DB::table('products')->insert([
            'product_name'=>$request->input('product_name'),
            'company_id'=>$request->input('company_id'),
            'price'=>$request->input('price'),
            'stock'=>$request->input('stock'),
            'comment'=>$request->input('comment'),
            'img_path'=>$img_path
        ]);
    }

    //更新処理(画像あり)
    public function updateProduct($request, $img_path, $id){
        DB::table('products')
        ->where('products.id', '=', $id)
        ->update([
            'product_name'=>$request->input('product_name'),
            'company_id'=>$request->input('company_id'),
            'price'=>$request->input('price'),
            'stock'=>$request->input('stock'),
            'comment'=>$request->input('comment'),
            'img_path'=>$img_path
        ]);
    }

    //更新処理(画像なし)
    public function updateProductNoImg($request, $id){
        DB::table('products')
        ->where('products.id', '=', $id)
        ->update([
            'product_name'=>$request->input('product_name'),
            'company_id'=>$request->input('company_id'),
            'price'=>$request->input('price'),
            'stock'=>$request->input('stock'),
            'comment'=>$request->input('comment'),
        ]);
    }

    //検索機能
    public function searchProduct($keyword, $company_name, $max_price, $min_price, $max_stock, $min_stock){
        $query = self::query();

            if (!empty($keyword)) {
                $query->where('product_name', 'LIKE', "%{$keyword}%");
            }    

            if (isset($company_name)) {
                $query->where('company_id', $company_name);
            }    
        
            // 上限価格の条件追加
            if ($max_price) {
                $query->where('price', '<=', $max_price);
            }
        
            // 下限価格の条件追加
            if ($min_price) {
                $query->where('price', '>=', $min_price);
            }
        
            if($max_stock){
                $query->where('stock','<=',$max_stock);
            }
        
            if($min_stock){
                $query->where('stock','>=',$min_stock);
            }
        
            $products = $query->get();
        
            return $products;    
        }


    // Companiesテーブルと関連付ける
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
}