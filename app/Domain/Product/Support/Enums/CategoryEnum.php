<?php

declare(strict_types=1);

namespace App\Domain\Product\Support\Enums;

use BenSampo\Enum\Enum;

final class CategoryEnum extends Enum
{
    public const DISCOUNTABLE_CATEGORIES = [
        'insurance' => '30',
    ];
}
