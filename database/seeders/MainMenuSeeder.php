<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('main_menus')->delete();
        $data = [
            ['menu_name'=>'Dashboard','short_name'=>"Dashboard",'route_name'=>'dashboard','root_menu_id'=>null,'sequence'=>1,'status_active'=>1],
            ['menu_name'=>'Home Management','short_name'=>"Home",'route_name'=>null,'root_menu_id'=>null,'sequence'=>2,'status_active'=>1],
            ['menu_name'=>'Settings','short_name'=>"Settings",'route_name'=>null,'root_menu_id'=>null,'sequence'=>3,'status_active'=>1],

            ['menu_name'=>'Home S1 Left','short_name'=>null,'route_name'=>'homeS1Left.index','root_menu_id'=>2,'sequence'=>1,'status_active'=>1],
            ['menu_name'=>'Home S1 Right','short_name'=>null,'route_name'=>'homeS1Right.index','root_menu_id'=>2,'sequence'=>2,'status_active'=>1],
            ['menu_name'=>'About','short_name'=>null,'route_name'=>'homeS2.index','root_menu_id'=>2,'sequence'=>3,'status_active'=>1],
            ['menu_name'=>'Partners Left','short_name'=>null,'route_name'=>'homeS3Left.index','root_menu_id'=>2,'sequence'=>4,'status_active'=>1],
            ['menu_name'=>'Partners Right','short_name'=>null,'route_name'=>'homeS3Right.index','root_menu_id'=>2,'sequence'=>5,'status_active'=>1],
            ['menu_name'=>'Services','short_name'=>null,'route_name'=>'homeS4.index','root_menu_id'=>2,'sequence'=>6,'status_active'=>1],
            ['menu_name'=>'Faq','short_name'=>null,'route_name'=>'faq.index','root_menu_id'=>2,'sequence'=>6,'status_active'=>1],
            ['menu_name'=>'Team','short_name'=>null,'route_name'=>'team.index','root_menu_id'=>2,'sequence'=>7,'status_active'=>1],
            ['menu_name'=>'Blog','short_name'=>null,'route_name'=>'blog.index','root_menu_id'=>2,'sequence'=>8,'status_active'=>1],
            ['menu_name'=>'Testimonial','short_name'=>null,'route_name'=>'testimonial.index','root_menu_id'=>2,'sequence'=>9,'status_active'=>1],

            ['menu_name'=>'Information Setup','short_name'=>null,'route_name'=>'info-setup.index','root_menu_id'=>3,'sequence'=>1,'status_active'=>1],
            ['menu_name'=>'Blog Categories','short_name'=>null,'route_name'=>'blog-category.index','root_menu_id'=>3,'sequence'=>3,'status_active'=>1],
        ];
        DB::table('main_menus')->insert($data);
    }
}
