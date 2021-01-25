<?php

namespace Modules\Project\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ProjectHasContent
 * @package Modules\Project\Entities
 *
 * @property int $id
 * @property int $project_id
 * @property int $entity_id
 * @property string $entity_type
 */
class ProjectHasContent extends Model
{
    protected $fillable = ['project_id', 'entity_id', 'entity_type'];
    public $timestamps = false;
}
