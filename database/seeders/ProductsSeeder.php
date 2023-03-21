<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('products')->insert([
            
            [
                'company_id' => '1',
                'product_name' => '商品1',
                'price' => '100',
                'stock' => '10',
                'comment' => '小学生の間で非常に好評です。とくに低学年におすすめです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_id' => '2',
                'product_name' => '商品2',
                'price' => '200',
                'stock' => '20',
                'comment' => '小学生の間で非常に好評です。とくに高学年におすすめです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_id' => '3',
                'product_name' => '商品3',
                'price' => '300',
                'stock' => '30',
                'comment' => '小学生の間で非常に好評です。保護者でも愛用者が多いです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_id' => '1',
                'product_name' => '商品4',
                'price' => '400',
                'stock' => '40',
                'comment' => '小学生の間で非常に好評です。とくに低学年におすすめです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_id' => '2',
                'product_name' => '商品5',
                'price' => '500',
                'stock' => '50',
                'comment' => '小学生の間で非常に好評です。とくに高学年におすすめです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_id' => '3',
                'product_name' => '商品6',
                'price' => '600',
                'stock' => '60',
                'comment' => '小学生の間で非常に好評です。保護者でも愛用者が多いです。',
                'img_path' => '',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],
        ]);
    }
}