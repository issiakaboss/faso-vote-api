<?php

namespace App\Helpers\OpenApiHelpers;

use OpenApi\Attributes as OA;

class RequestBodyHelper extends OA\RequestBody
{
    public function __construct(array $properties, array $required = [])
    {
        return parent::__construct(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    properties: $properties,
                    required: $required

                )
            )
        );
    }
}
