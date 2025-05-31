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
                new OA\Property(property: 'vote_uuid', type: 'string', example: '123e4567-e89b-12d3-a456-426614174000', description: 'UUID of the vote'),
                new OA\Property(property: 'country_code', type: 'string', example: '+226', description: 'Country code of the voter'),
                new OA\Property(property: 'country_iso_code', type: 'string', example: 'FR', description: 'ISO code of the country'),
            ],
            required: ['phone'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'votant'),
        ]
    )]
    public function storeByPhone() {}

    #[OA\Post(
        path: self::GUEST_BASE_PATH.'/votant/verify-phone',
        tags: [self::GUEST_VOTE],
        requestBody: new RequestBodyHelper(
            [
                new OA\Property(property: 'otp', type: 'integer', example: 123456, description: 'One-time password sent to the voter'),
                new OA\Property(property: 'vote_id', type: 'integer', example: 1, description: 'ID of the vote'),
                new OA\Property(property: 'identity', type: 'string', example: 'john_doe', description: 'Identity of the voter'),
            ],
            required: ['phone'],
        ),
        security: [['sanctum' => []]],
        responses: [
            new RequestResponseHelper(ref: 'votant'),
        ]
    )]
    public function verifyOtp() {}
}
