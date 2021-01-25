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
    protected $fillable = ['project_id', 'headline', 'first_name'];
    public $timestamps = false;
}
