<?php

namespace App\Models\Enums;

enum VotantStatusEnum: string implements AdvancedEnumInterface
{
    use AdvancedEnum;

    case PENDING = 'pending';
    case VOTED = 'voted';
    case INVALID = 'invalid';
}
