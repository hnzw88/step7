<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function createProduct($inputs){
        $products = Product::create([
            'product_name'=>$inputs['product_name'],
            'company_id'=>$inputs['company_id'],
            'price'=>$inputs['price'],
            'stock'=>$inputs['stock'],
            'comment'=>$inputs['comment'],
            'img_path'=>$inputs['path'],
        ]);
    }

    public function updateProduct($inputs){
        $product = Product::find($inputs['id']);
        $product->fill([
            'product_name'=>$inputs['product_name'],
            'company_id'=>$inputs['company_id'],
            'price'=>$inputs['price'],
            'stock'=>$inputs['stock'],
            'comment'=>$inputs['comment'],
            'img_path'=>$inputs['path'],
        ]);
        $product->save();
    }

    //検索機能
    public function searchProduct($keyword, $query){
        if (!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }
    }

    public function searchCompany($company_name, $query){
        if (isset($company_name)) {
            $query->where('company_id', $company_name);
        }
    }

    // Companiesテーブルと関連付ける
    public function company(){
        return $this->belongsTo('App\Models\Company');
    }
}