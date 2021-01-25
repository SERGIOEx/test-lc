<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

/**
 * Class ProjectArticle
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property string $title
 * @property string $content
 */
class ProjectArticle extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $fillable = ['title', 'content'];
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
