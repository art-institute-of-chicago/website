<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public $seeders = [
        PagesTableSeeder::class,
        HoursTableSeeder::class,
        HomePageSeeder::class,
        MembershipMagazinePageSeeder::class,
        VisitPageSeeder::class,
        EmailSeriesSeeder::class,
    ];

    public function run(): void
    {
        $this->call(PagesTableSeeder::class);
        $this->call(HoursTableSeeder::class);
    }
}
