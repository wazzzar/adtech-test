<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class Proxy extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \App\Models\Proxy::factory(10)->create();
    }
}
