<?php

namespace Database\Seeders;

use App\Models\Lang;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         Lang::create([
             'title' => 'Kazakh',
             'code' => 'kz'
         ]);
        Lang::create([
            'title' => 'Russion',
            'code' => 'ru'
        ]);
        Lang::create([
            'title' => 'English',
            'code' => 'en'
        ]);
    }
}
