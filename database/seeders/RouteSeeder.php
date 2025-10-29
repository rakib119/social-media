<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class RouteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('routes')->delete();
        $routes     = array();
        $exceptArr  = [ ''=>'','login'=>'login','logout'=>'logout','register'=>'register','password.request'=>'password.request','password.email'=>'password.email','password.reset'=>'password.reset','password.update'=>'password.update','password/confirm'=>'password/confirm','password.confirm'=>'password.confirm','home'=>'home','about'=>'about','services'=>'services','teams'=>'teams','service.details'=>'service.details','team_details'=>'team_details','blog'=>'blog','blog-details'=>'blog-details','blog.category'=>'blog.category','kyc'=>'kyc',];

        foreach (Route::getRoutes() as $route) {
            $url    = $route->uri();
            $name   = $route->getName();
            $status = isset($exceptArr[$name]) ? false : true;

            $link_type = array(1=>'index',2=>'save',3=>'update',4=>'delete',5=>'details',6=>'published');

            if ($status)
            {
                $type = 0;
                if (stripos($name,"index")) {$type = 1;}
                else if (stripos($name,"create")||stripos($name,"store")) {$type = 2;}
                else if (stripos($name,"edit")||stripos($name,"update")) {$type = 3;}
                else if (stripos($name,"destroy")||stripos($name,"delete")) {$type = 4;}
                else if (stripos($name,"show")||stripos($name,"details")||stripos($name,"dtls")) {$type = 5;}
                else if (stripos($name,"pub"||stripos($name,"publish"))) {$type = 6;}

                $routes []= [ 'url' => $url, 'route' =>$name, 'name'=>$name, 'route_type'=>$type ];
            }
        }
        sort($routes);
        DB::table('routes')->insert($routes);

    }
}
