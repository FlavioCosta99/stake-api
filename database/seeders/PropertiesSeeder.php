<?php

namespace Database\Seeders;

use Database\Factories\PropertyFactory;
use Illuminate\Database\Seeder;

class PropertiesSeeder extends Seeder
{
    public function run(): void
    {
        PropertyFactory::new()->count(10)->create();
    }
}
