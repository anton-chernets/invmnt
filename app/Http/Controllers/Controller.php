<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(title="My First API", version="0.1"),
 * @OA\SecurityScheme(
 *    description="Api Key for authorization.",
 *    securityScheme="Authorization",
 *    type="apiKey",
 *    in="header",
 *    name="Authorization"
 *  )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
