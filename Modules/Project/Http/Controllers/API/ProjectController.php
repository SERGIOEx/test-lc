<?php

namespace Modules\Project\Http\Controllers\API;

use App\Core\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Project\Responses\ProjectResponse;
use Modules\Project\Services\ProjectService;
use Modules\Project\Transformers\ProjectTransformer;

class ProjectController extends ApiController
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * Get By id
     *
     * TODO: send data to transformer (need fix error)
     * $this->transform($item, ProjectTransformer::class);
     *
     * @param $id
     * @return JsonResponse
     */
    public function getById($id)
    {
        $item = $this->service->findById($id);
        return $this->json(ProjectResponse::get($item));
    }
}
