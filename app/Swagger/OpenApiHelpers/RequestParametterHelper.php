<?php

namespace App\Swagger\OpenApiHelpers;

use OpenApi\Attributes as OA;

class RequestParametterHelper extends OA\RequestBody
{
    public function __construct(...$properties)
    {
        return parent::__construct(
            content: new OA\MediaType(
                mediaType: 'application/json',
                schema: new OA\Schema(
                    type: 'object',
                    properties: $properties

                )
            )
        );
    }
}
