<?php

namespace Modules\Project\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\Project;
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
            $project = Project::inRandomOrder()->first();

            $article = ProjectUser::create([
                'headline'   => $faker->name,
                'first_name' => $faker->firstName
            ]);

            $article->projects()->save($project);
        }
    }
}
