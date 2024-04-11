<?php

namespace App\Shared\Dtos;

use App\Shared\Enums\Visibility;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\LiteralTypeScriptType;
use App\Rules\ListEntries;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Rule;

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
    /** @var array<ListEntry> */
    #[Min(1)]
    #[Max(200)]
    #[Rule(new ListEntries)]
    public array $selectedGames;
}

/** @typescript */
class ListEntry extends Data
{
    #[Max(5000)]
    #[LiteralTypeScriptType("string")]
    public ?string $note;
    public int $id;
    public ?int $rank;
}
