<?php

namespace Modules\Project\Transformers;

use App\Core\Parents\Transformer\Transformer;
use Modules\Project\Entities\Project;

class ProjectTransformer extends Transformer
{
    /**
     * @param Project $entity
     *
     * @return array
     */
    public function transform(Project $entity)
    {
        return $entity->toArray();
    }
}
