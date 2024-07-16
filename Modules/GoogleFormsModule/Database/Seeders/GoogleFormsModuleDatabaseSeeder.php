<?php

namespace Modules\GoogleFormsModule\Database\Seeders;

use Illuminate\Database\Seeder;

class GoogleFormsModuleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $this->call([
            SeedQuestionsSeederSeeder::class,
        ]);
    }
}
