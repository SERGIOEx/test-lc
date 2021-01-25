<?php

namespace Modules\Project\Database\Seeders;

use App\Core\Modules\Media\MediaUploadTrait;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectArticle;

class SeedFakeProjectArticlesTableSeeder extends Seeder
{
    use MediaUploadTrait;

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

            $article = ProjectArticle::create([
                'title'   => $faker->name,
                'content' => $faker->text
            ]);

            $this->addMediaFromUrl(
                'https://www.istockphoto.com/resources/images/HomePage/FourPack/Illustrations-907872186.jpg',
                $article);

            $article->projects()->save($project);
        }

    }
}
