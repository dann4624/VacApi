<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *     description="Cool Corona API.",
 *     version="1.0.0",
 *     title="Cool Corona API",
 *     @OA\Contact(
 *         email="dann4624@edu.sde.dk"
 *     ),
 *
 * )
 *   @OA\Server(
 *         url="https://vacapi.semeicardia.online/api"
 *     )
 * @OA\PathItem(path="/api/")
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat="JWT",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
