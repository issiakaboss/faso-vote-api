<?php
namespace App;
use OpenApi\Annotations as OA;
/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Fusion Center Documentation",
 *     description="Fusion Center Documentation"
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000/api",
 *     description="Local server"
 * )
 *
 * @OA\Server(
 *     url="http://staging.example.com",
 *     description="Staging server"
 * )
 *
 * @OA\Server(
 *     url="http://example.com",
 *     description="Production server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     name="Authorization",
 *     in="header"
 * )
 */

 class OpenApi {}
