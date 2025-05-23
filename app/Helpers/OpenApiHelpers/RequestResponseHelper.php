<?php

namespace App\Helpers\OpenApiHelpers;

use OpenApi\Attributes as OA;

class RequestResponseHelper extends OA\Response
{
    public function __construct(
        bool $isCollection = false,
        ?string $ref = null,
        int $code = 200,
        string $description = 'Success',
        array $extraProperties = []
    ) {
        return parent::__construct(
            response: $code,
            description: $description,
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    properties: [
                        new OA\Property(
                            property: 'data',
                            type: $isCollection ? 'array' : 'object',
                            ref: $isCollection ? null : self::getRef($ref),
                            items: $isCollection ? new OA\Items(type: 'object', ref: self::getRef($ref)) : null,
                        ),
                        ...$extraProperties,
                        new OA\Property(property: 'status', type: 'integer', example: $code),
                        new OA\Property(property: 'message', type: 'string', example: $description),
                        new OA\Property(property: 'success', type: 'bool', example: true),

                    ],

                )

            )
        );
    }

    private static function getRef(?string $ref): ?string
    {
        return $ref ? "#/components/schemas/$ref" : null;
    }
}
