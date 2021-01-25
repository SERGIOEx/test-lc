<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * Class Project
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property string $title
 * @property string $description
 */
class Project extends Model
{
    protected $fillable = ['title', 'description'];
    public $timestamps = false;


    /**
     * Get Project Articles
     * @return MorphToMany
     */
    public function project_articles()
    {
        return $this->morphedByMany(
            ProjectArticle::class,
            'model',
            'project_has_contents');
    }

    /**
     * Get Project Users
     * @return MorphToMany
     */
    public function project_users()
    {
        return $this->morphedByMany(
            ProjectUser::class,
            'model',
            'project_has_contents');
    }
}
