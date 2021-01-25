<?php


namespace App\Core\Modules\Media;


use App\Core\Exceptions\InternalErrorException;

trait MediaUploadTrait
{

    /**
     * @param string $url
     * @param $entity
     * @return mixed
     */
    public function addMediaFromUrl(string $url, $entity)
    {
        if (!method_exists($entity, 'addMediaFromUrl')) {
            throw (new InternalErrorException(
                'Method addMediaFromUrl doesn\'t exist; Include HasMediaTrait into your model'
            ));
        }

        return $entity->addMediaFromUrl($url)->toMediaCollection();
    }

}
