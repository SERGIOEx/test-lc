<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
/**
 * Class ProjectUser
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property string $headline
 * @property string $first_name
 */
class ProjectUser extends Model
{

    protected $fillable = ['headline', 'first_name'];
    public $timestamps = false;

    /**
     * Get all of the contents for the project article.
     */
    public function projects()
    {
        return $this->morphToMany(
            Project::class,
            'model',
            'project_has_contents'
        );
    }
}
