<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialPackageFeatureDtlsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_package_feature_dtls')->delete();
		$feature = array(
			array('id' => 1,'mst_id' => 1, 'feature' => '20 to 1.5 Luk Taka Income', 'short_desc' => 'The maximum amount of websites allowed per account.'),
			array('id' => 2,'mst_id' => 1, 'feature' => 'Lifetime Support', 'short_desc' => 'The maximum amount of websites allowed per account.'),
			array('id' => 3,'mst_id' => 1, 'feature' => '6 Hours Live Class Support', 'short_desc' => 'The maximum amount of websites allowed per account.'),

			array('id' => 4,'mst_id' => 2, 'feature' => '20 to 1.5 Luk Taka Income', 'short_desc' => 'The maximum amount of websites allowed per account.'),
			array('id' => 5,'mst_id' => 2, 'feature' => 'Lifetime Support', 'short_desc' => 'The maximum amount of websites allowed per account.'),
			array('id' => 6,'mst_id' => 2, 'feature' => '6 Hours Live Class Support', 'short_desc' => 'The maximum amount of websites allowed per account.'),
		);

		DB::table('social_package_feature_dtls')->insert($feature);
    }
}
