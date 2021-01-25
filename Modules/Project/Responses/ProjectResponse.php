<?php


namespace Modules\Project\Responses;


use Modules\Project\Entities\Project;

class ProjectResponse
{
    public static function get(Project $entity)
    {
        return self::format($entity);
    }

    protected static function format(Project $entity)
    {
        return [
            'object'      => 'Project',
            'id'          => $entity->id,
            'title'       => $entity->title,
            'description' => $entity->description,
            'articles'    => $entity->project_articles,
            'users'       => $entity->project_users,
        ];
    }
}
