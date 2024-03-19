<?php

namespace App\Shared\Enums;

enum Visibility: string
{

    case Public = 'public';

    case Link = 'link';

    case Private = 'private';
}
