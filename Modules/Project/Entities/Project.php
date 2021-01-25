<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * Project Articles
     * @return HasMany
     */
    public function project_articles()
    {
        return $this->hasMany(ProjectArticle::class, 'project_id', 'id');
    }

    /**
     * Project Users
     * @return HasMany
     */
    public function project_users()
    {
        return $this->hasMany(ProjectUser::class, 'project_id', 'id');
    }
}
