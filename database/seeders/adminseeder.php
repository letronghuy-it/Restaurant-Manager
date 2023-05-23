<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->delete();
        DB::table('admins')->truncate();

        DB::table('admins')->insert([
            [
                'ho_va_ten'     => 'admin@master',
                'email'         => 'hale.02031982@gmail.com',
                'so_dien_thoai' => '0983057130',
                'ngay_sinh'     => '2003-10-01',
                'password'      => bcrypt('letronghuy113'),
                'hash_reset'    => null,
                'id_quyen'      => 1,
            ],
        ]);

    }
}
