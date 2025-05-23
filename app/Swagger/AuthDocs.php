<?php

namespace App\Swagger;

use App\Swagger\OpenApiHelpers\RequestBodyHelper;
use App\Swagger\OpenApiHelpers\RequestResponseHelper;
use OpenApi\Attributes as OA;


#[OA\Schema(
    schema: 'user',
    type: 'object',
    properties: [
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'email', type: 'string'),
    ]
)]
class AuthDocs extends Docs
{
    public const BASE_PATH = parent::BASE_PATH . '/auth';

    public const AUTH = 'Auth';

    #[OA\Post(
        path: self::BASE_PATH . '/login',
        tags: [self::AUTH],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'email', type: 'string', example: 'test@example.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
            ],
            required: ['email', 'password']
        ),
        responses: [
            new RequestResponseHelper(ref: 'user', extraProperties: [
                new OA\Property(property: 'token', type: 'string', example: '3RsOxSU2byZe8209aEW2j'),
            ]),
        ]
    )]
    public function login() {}

    #[OA\Post(
        path: self::BASE_PATH . '/register',
        tags: [self::AUTH],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'email', type: 'string', example: "user@exemple.com"),
                new OA\Property(property: 'name', type: 'string', example: "User Name"),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
                new OA\Property(property: 'password_confirmation', type: 'string', example: 'password'),
            ],
            required: ['phone', 'password'],
        ),
        responses: [
            new RequestResponseHelper(ref: 'user'),
        ]
    )]
    public function register() {}

    #[OA\Post(
        path: self::BASE_PATH . '/logout',
        tags: [self::AUTH],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'user'),
        ]
    )]
    public function logout() {}
}
