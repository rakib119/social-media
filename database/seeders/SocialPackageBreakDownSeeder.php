<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialPackageBreakDownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // sub_package_name
        // desc_link
        // price
        // discount_per
        // discounted_amount

        DB::table('social_package_break_down')->delete();
		$package = array(
			array('id' => 1,'mst_id' => 1,'sub_package_name' => 'Package 1', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 15000 ,'discount_per' => 14,'discounted_amount' => 12900),
			array('id' => 2,'mst_id' => 1,'sub_package_name' => 'Package 2', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 9000 ,'discount_per' => 0,'discounted_amount' => 9000),
			array('id' => 3,'mst_id' => 1,'sub_package_name' => 'Package 3', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 6000 ,'discount_per' => 0,'discounted_amount' => 6000),
			array('id' => 4,'mst_id' => 1,'sub_package_name' => 'Package 4', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 3000 ,'discount_per' => 0,'discounted_amount' => 3000),

			array('id' => 5,'mst_id' => 2,'sub_package_name' => 'Package 5', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 9000 ,'discount_per' => 14,'discounted_amount' => 7200),
			array('id' => 6,'mst_id' => 2,'sub_package_name' => 'Package 6', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 5000 ,'discount_per' => 0,'discounted_amount' => 5000),
			array('id' => 7,'mst_id' => 2,'sub_package_name' => 'Package 7', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 2500 ,'discount_per' => 0,'discounted_amount' => 2500),
			array('id' => 8,'mst_id' => 2,'sub_package_name' => 'Package 8', 'desc_link' => 'https://www.ascentaverse.com/blog/details/esentavars-saflzer-ntun-dignt', 'price' => 1500 ,'discount_per' => 0,'discounted_amount' => 1500)
		);

		DB::table('social_package_break_down')->insert($package);
    }
}
