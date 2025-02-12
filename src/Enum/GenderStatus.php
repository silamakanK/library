<?php

namespace App\Enum;

enum GenderStatus: string
{
    case MALE = 'male';
    case FEMALE = 'female';

    public static function getGender(): array
    {
//        return match ($this) {
//            self::MALE => 'male',
//            self::FEMALE => 'female',
//        };
        return [
            'Male' => self::MALE->value,
            'Female' => self::FEMALE->value,
        ];
    }
}