<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(SocialIconSeeder::class);
        $this->call(GenarelInfoSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(MainMenuSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(DivisionSeeder::class);
        $this->call(DistrictSeeder::class);
        $this->call(UpazilaSeeder::class);
        $this->call(UnionSeeder::class);
        $this->call(SocialPackageMstSeeder::class);
        $this->call(SocialPackageFeatureDtlsSeeder::class);
        $this->call(SocialPackageMstSeeder::class);
        $this->call(BankSeeder::class);
    }
}
