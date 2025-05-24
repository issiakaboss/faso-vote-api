<?php

namespace App\Swagger;

use App\Swagger\OpenApiHelpers\RequestBodyHelper;
use App\Swagger\OpenApiHelpers\RequestResponseHelper;
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
class VoteDocs extends Docs
{
    public const BASE_PATH = parent::BASE_PATH.'/votes';

    public const VOTE = 'Vote';

    #[OA\Get(
        path: self::BASE_PATH.'',
        tags: [self::VOTE],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote', isCollection: true),
        ]
    )]
    public function getVotes() {}

    #[OA\Get(
        path: self::BASE_PATH.'/{vote}',
        tags: [self::VOTE],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: 1),
        ],
        responses: [
            new RequestResponseHelper(ref: 'vote', isCollection: true),
        ]
    )]
    public function show() {}

    #[OA\Get(
        path: self::BASE_PATH.'/{vote}/edit',
        tags: [self::VOTE],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: 1),
        ],
        responses: [
            new RequestResponseHelper(ref: 'vote', isCollection: true),
        ]
    )]
    public function edit() {}

    #[OA\Post(
        path: self::BASE_PATH.'',
        tags: [self::VOTE],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'title', type: 'string', example: 'Vote Title'),
                new OA\Property(property: 'description', type: 'string', example: 'Vote Description'),
                new OA\Property(property: 'start_date', type: 'string', format: 'date-time', example: '2025-10-01T00:00:00Z'),
                new OA\Property(property: 'end_date', type: 'string', format: 'date-time', example: '2025-10-03T23:59:59Z'),
                new OA\Property(property: 'logo', type: 'string', format: 'binary', example: 'logo.png'),
            ],
            required: ['title', 'start_date', 'end_date'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function store() {}

    #[OA\Put(
        path: self::BASE_PATH.'/{vote}',
        tags: [self::VOTE],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: '1', allowEmptyValue: false),
        ],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'title', type: 'string', example: 'Vote Title'),
                new OA\Property(property: 'description', type: 'string', example: 'Vote Description'),
                new OA\Property(property: 'start_date', type: 'string', format: 'date-time', example: '2025-10-01T00:00:00Z'),
                new OA\Property(property: 'end_date', type: 'string', format: 'date-time', example: '2025-10-31T23:59:59Z'),
                new OA\Property(property: 'logo', type: 'string', format: 'binary', example: 'logo.png'),
            ],
            required: ['title', 'start_date', 'end_date'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function update() {}

    #[OA\Delete(
        path: self::BASE_PATH.'/{vote}',
        tags: [self::VOTE],
        parameters: [
            new OA\Parameter(name: 'vote', in: 'path', description: 'Vote id', required: true, example: 1),
        ],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'vote'),
        ]
    )]
    public function destroy() {}
}
