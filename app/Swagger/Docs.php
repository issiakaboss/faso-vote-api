<?php

namespace App\Swagger;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'vote',
    type: 'object',
    properties: [
        new OA\Property(property: 'title', type: 'string'),
        new OA\Property(property: 'uuid', type: 'string'),
        new OA\Property(property: 'logo', type: 'string'),
        new OA\Property(property: 'status', type: 'string'),
        new OA\Property(property: 'description', type: 'string'),
    ]
)]

abstract class Docs
{
    public const BASE_PATH = '/api';
}
