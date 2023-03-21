<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

     //テーブル名
     protected $table = 'companies';

     // 可変項目
     protected $fillable =
     [
         'company_name',
         'street_address',
         'representative_name'
     ];
 
     
 
     // Productsテーブルと関連付ける
     public function products(){
         return $this -> hasMany('App\Models\Product');
     }
}