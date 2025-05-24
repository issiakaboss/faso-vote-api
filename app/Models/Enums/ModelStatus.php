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

    public function getFlutterColor(): string
    {
        return match ($this) {
            self::ACTIVE => '0xFF4CAF50',
            self::INACTIVE => '0xFFB00020'
        };
    }
}
