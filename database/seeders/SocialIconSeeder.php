<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialIconSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_icons')->delete();
        $data = [
            ['name' => 'Facebook',  'icon' => "<i class='fab fa-facebook-f'></i>"],
            ['name' => 'Instagram', 'icon' => "<i class='fab fa-instagram'></i>"],
            ['name' => 'Twitter',   'icon' => "<i class='fab fa-twitter'></i>"]
        ];
        DB::table('social_icons')->insert($data);
    }
}
