<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use App\Models\City;
use App\Models\District;
use App\Models\Village;
use App\Models\User;
use App\Models\Country;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->reset();

        $this->call(CitiesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(DistrictsSeeder::class);
        $this->call(VillagesSeeder::class);
        $this->call(UserSeeder::class);
    }

    public function reset()
    {
        Schema::disableForeignKeyConstraints();

        Village::truncate();
        District::truncate();
        City::truncate();
        User::truncate();
        Country::truncate();

        Schema::disableForeignKeyConstraints();
    }
}
