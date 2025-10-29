<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialPackageMstSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_package_mst')->delete();
		$package = array(
			array('id' => 1,'package_name' => 'Premium', 'short_desc' => 'Everything you need to create your website.', 'price' => 15000 ,'discount_per' => 14,'discounted_amount' => 12900,'renewable_message' => '৳ 600/mo when you renew'),
			array('id' => 2,'package_name' => 'Regular', 'short_desc' => 'Everything you need to create your website.', 'price' => 9000 ,'discount_per' => 14,'discounted_amount' => 7740,'renewable_message' => '৳ 300/mo when you renew')
		);

		DB::table('social_package_mst')->insert($package);
    }
}
