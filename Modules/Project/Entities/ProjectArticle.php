<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectArticle
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property string $title
 * @property string $content
 */
class ProjectArticle extends Model
{
    protected $fillable = ['title', 'content'];
    public $timestamps = false;

    /**
     * Get all of the contents for the project article.
     */
    public function contents()
    {
      // TODO: morphToMany Content model
    }
}
