<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

class BaseModel extends Model
{
    use HasFactory;

    public static function validationRules(): array
    {
        return [];
    }

    public static function getValidationRule(string $name): array
    {
        return Arr::add([], $name, Arr::get(static::validationRules(), $name, []));
    }

    public static function getValidationRules(array $names): array
    {
        $validations = [];
        foreach ($names as $name) {
            Arr::set($validations, $name, Arr::get(static::validationRules(), $name, []));
        }

        return $validations;
    }

    public static function random(): ?self
    {
        return static::inRandomOrder()->first();
    }
}
