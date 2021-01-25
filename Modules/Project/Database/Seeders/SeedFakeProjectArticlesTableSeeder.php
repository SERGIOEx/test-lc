<?php

namespace Modules\Project\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectArticle;

class SeedFakeProjectArticlesTableSeeder extends Seeder
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
                'title'      => $faker->name,
                'content'    => $faker->text
            ];
        }

        ProjectArticle::insert($data);
    }
}
