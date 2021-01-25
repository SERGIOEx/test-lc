<?php

namespace Modules\Project\Services;


use Modules\Project\Entities\Project;
use App\Core\Core\Exceptions\Exception;
use App\Core\Exceptions\InternalErrorException;

class ProjectService
{
    /**
     * Get Project by id
     * @param int $id
     * @return mixed
     */
    public function findById(int $id)
    {
        try {
            return Project::findOrFail($id);
        } catch (Exception $exception) {
            throw (new InternalErrorException())->debug($exception);
        }
    }

}
