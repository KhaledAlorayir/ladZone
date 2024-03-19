<?php

namespace App\Shared\Dtos;

use App\Shared\Enums\Visibility;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;

/** @typescript */
class CreateListData extends Data
{
    #[LiteralTypeScriptType("string[]")]
    public array $visibilityTypes;

    public function __construct()
    {
        $this->visibilityTypes = array_column(Visibility::cases(), 'value');
    }
}
