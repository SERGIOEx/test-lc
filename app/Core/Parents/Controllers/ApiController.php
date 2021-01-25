<?php

namespace App\Core\Parents\Controllers;

use App\Core\Parents\Traits\ResponseTrait;
use App\Http\Controllers\Controller;

/**
 * Class ApiController.
 *
 */
abstract class ApiController extends Controller
{
    use ResponseTrait;
}

