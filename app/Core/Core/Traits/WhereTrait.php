<?php

namespace App\Core\Core\Traits;

use App\Core\Core\Exceptions\ClassDoesNotExistException;
use App\Core\Core\Exceptions\MissingContainerException;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

/**
 * Class CallableTrait.
 *
 */
trait WhereTrait
{
    public function deleteWhereIn($field, $value)
    {
        return $this->model->whereIn($field, $value)->delete();
    }

    /**
     * @param array $attr
     * @param string $field
     * @param array $condition
     */
    public function updateWhereIn(array $attr, string $field, array $condition)
    {
        $this->applyCriteria();
        $this->model->whereIn($field, $condition)->update($attr);
    }
}
