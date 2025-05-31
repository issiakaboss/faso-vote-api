<?php

namespace App\Swagger;

use App\Swagger\OpenApiHelpers\RequestBodyHelper;
use App\Swagger\OpenApiHelpers\RequestResponseHelper;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'votant',
    type: 'object',
    properties: [
        new OA\Property(property: 'id', type: 'integer'),
        new OA\Property(property: 'vote_id', type: 'integer', description: 'ID of the vote'),
        new OA\Property(property: 'identity', type: 'string', description: 'Identity of the voter'),
    ]
)]
class VotantDocs extends Docs
{
    public const GUEST_VOTE = 'Guest Vote';

    public const GUEST_BASE_PATH = parent::BASE_PATH.'/vote';

    #[OA\Post(
        path: self::GUEST_BASE_PATH.'/votant/phone',
        tags: [self::GUEST_VOTE],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'phone', type: 'string', example: '+33612345678', description: 'Phone number of the voter'),

            ],
            required: ['phone'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'votant'),
        ]
    )]
    public function storeByPhone() {}
}
