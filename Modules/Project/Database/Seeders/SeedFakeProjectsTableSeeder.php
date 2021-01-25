<?php

namespace Modules\Project\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Modules\Project\Entities\Project;

class SeedFakeProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create(config('app.faker_locale'));

        // generate
        for ($i = 0; $i < env('ENTITY_GENERATE_CNT'); $i++) {
            $data[] = [
                'title'       => $faker->name,
                'description' => $faker->text
            ];
        }

        Project::insert($data);
    }
}
