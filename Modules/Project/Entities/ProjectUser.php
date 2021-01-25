<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class ProjectUser
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property string $headline
 * @property string $first_name
 */
class ProjectUser extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['headline', 'first_name'];
    public $timestamps = false;

    /**
     * Get Projects
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
