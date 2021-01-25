<?php

namespace Modules\Project\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\ProjectUser;

class SeedFakeProjectUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $faker = Faker::create(config('app.faker_locale'));

        // generate
        for ($i = 0; $i < env('ENTITY_GENERATE_CNT'); $i++) {
            $data[] = [
                'headline'   => $faker->name,
                'first_name' => $faker->firstName
            ];
        }

        ProjectUser::insert($data);
    }
}
