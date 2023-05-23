<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KhuVucSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('khu_vucs')->delete();
        DB::table('khu_vucs')->truncate();

        DB::table('khu_vucs')->insert([
            [
                'ten_khu_vuc'       =>'Khu Thường',
                'slug_khu_vuc'      =>'khu-thường',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_khu_vuc'       =>'Khu VIP',
                'slug_khu_vuc'      =>'khu-vip',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_khu_vuc'       =>'Khu Đặt Biệt',
                'slug_khu_vuc'      =>'khu-dat-biet',
                'tinh_trang'    => random_int(0, 1),
            ],
            [
                'ten_khu_vuc'       =>'Khu Đám Cưới',
                'slug_khu_vuc'      =>'khu-dam-cuoi',
                'tinh_trang'    => random_int(0, 1),
            ],
        ]);
    }
}
