<?php

namespace App\Models\Enums;

enum ModelStatus: string implements AdvancedEnumInterface
{
    use AdvancedEnum;

    case ACTIVE = 'active';
    case INACTIVE = 'inactive';

    public function getColor(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::INACTIVE => 'danger',
        };
    }
}
