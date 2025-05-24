<?php

namespace App\Swagger;

use App\Swagger\OpenApiHelpers\RequestBodyHelper;
use App\Swagger\OpenApiHelpers\RequestResponseHelper;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'candidate',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'name', type: 'string'),
        new OA\Property(property: 'description', type: 'string'),
        new OA\Property(property: 'profession', type: 'string'),
        new OA\Property(property: 'university', type: 'string'),
        new OA\Property(property: 'photo', type: 'string'),
        new OA\Property(property: 'votes_count', type: 'integer'),
    ]
)]

class CandidateDocs extends Docs
{
    public const BASE_PATH = parent::BASE_PATH.'/candidates';

    public const CANDIDATE = 'Candidate';

    #[OA\Delete(
        path: self::BASE_PATH.'/{candidate}/edit',
        tags: [self::CANDIDATE],
        parameters: [
            new OA\Parameter(name: 'candidate', in: 'path', description: 'Candidate id', required: true, example: 1),
        ],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'candidate', isCollection: true),
        ]
    )]
    public function edit() {}

    #[OA\Post(
        path: self::BASE_PATH.'',
        tags: [self::CANDIDATE],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'vote_id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'Candidate Name'),
                new OA\Property(property: 'description', type: 'string', example: 'Candidate Description'),
                new OA\Property(property: 'profession', type: 'string', example: 'Candidate Profession'),
                new OA\Property(property: 'university', type: 'string', example: 'Candidate University'),
                new OA\Property(property: 'photo', type: 'string', format: 'binary'),
            ],
            required: ['vote_id',  'name'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'candidate'),
        ]
    )]
    public function store() {}

    #[OA\Put(
        path: self::BASE_PATH.'/{candidate}',
        tags: [self::CANDIDATE],
        parameters: [
            new OA\Parameter(name: 'candidate', in: 'path', description: 'Candidate id', required: true, example: 1),
        ],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'vote_id', type: 'integer', example: 1),
                new OA\Property(property: 'name', type: 'string', example: 'Candidate Name'),
                new OA\Property(property: 'description', type: 'string', example: 'Candidate Description'),
                new OA\Property(property: 'profession', type: 'string', example: 'Candidate Profession'),
                new OA\Property(property: 'university', type: 'string', example: 'Candidate University'),
                new OA\Property(property: 'photo', type: 'string', format: 'binary'),
            ],
            required: ['vote_id',  'name'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'candidate'),
        ]
    )]
    public function update() {}

    #[OA\Get(
        path: self::BASE_PATH.'/{candidate}',
        tags: [self::CANDIDATE],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: 'candidate', in: 'path', description: 'Candidate id', required: true, example: 1),
        ],
        responses: [
            new RequestResponseHelper(ref: 'candidate', isCollection: true),
        ]
    )]
    public function show() {}

    #[OA\Delete(
        path: self::BASE_PATH.'/{candidate}',
        tags: [self::CANDIDATE],
        parameters: [
            new OA\Parameter(name: 'candidate', in: 'path', description: 'Candidate id', required: true, example: 1),
        ],
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'candidate'),
        ]
    )]
    public function destroy() {}
}
