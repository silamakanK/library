<?php

namespace App\Enum;

enum GenderStatus: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public function getGender(): string
    {
        return match ($this) {
            self::MALE => 'male',
            self::FEMALE => 'female',
        };
    }
}