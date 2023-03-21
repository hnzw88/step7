<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('companies') -> insert([

            [
                'company_name' => '株式会社A',
                'street_address' => '東京都港区芝公園4-2-8',
                'representative_name' => '田中　一郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_name' => '株式会社B',
                'street_address' => '東京都墨田区押上1-1-2',
                'representative_name' => '佐藤　花子',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

            [
                'company_name' => '株式会社C',
                'street_address' => '東京都港区赤坂9-7-1',
                'representative_name' => '鈴木　三郎',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => null,
            ],

        ]);
    }
}