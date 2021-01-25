<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

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
}
