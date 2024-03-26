<?php

namespace App\Shared\Dtos;

use App\Shared\Enums\Visibility;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\Nullable;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;

/** @typescript */
class CreateListRequest extends Data
{
    #[Max(255)]
    public string $title;
    #[Max(5000)]
    #[LiteralTypeScriptType("string")]
    public ?string $description;
    #[LiteralTypeScriptType("string")]
    public Visibility $visibility;
    public bool $ranked;
    // TODO validaite all ids exist, create controller
    /** @var array<ListEntry> */
    public array $selectedGames;
}

/** @typescript */
class ListEntry extends Data
{
    #[Max(5000)]
    #[LiteralTypeScriptType("string")]
    public ?string $note;
    public int $id;
}
