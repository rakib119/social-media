<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permissions')->delete();
        $data = [
            ['user_id'=>1,'link_id'=>null,'menu_id'=>2,'view'=>'1','save'=>'1','update'=>'1','delete'=>'1','details'=>'1','published'=>'1','inserted_by'=>1,'updated_by'=>null],
            ['user_id'=>1,'link_id'=>null,'menu_id'=>3,'view'=>'1','save'=>'1','update'=>'1','delete'=>'1','details'=>'1','published'=>'1','inserted_by'=>1,'updated_by'=>null],
            ['user_id'=>1,'link_id'=>null,'menu_id'=>4,'view'=>'1','save'=>'1','update'=>'1','delete'=>'1','details'=>'1','published'=>'1','inserted_by'=>1,'updated_by'=>null],
            ['user_id'=>1,'link_id'=>null,'menu_id'=>6,'view'=>'1','save'=>'1','update'=>'1','delete'=>'1','details'=>'1','published'=>'1','inserted_by'=>1,'updated_by'=>null],
        ];
        DB::table('permissions')->insert($data);
    }
}
