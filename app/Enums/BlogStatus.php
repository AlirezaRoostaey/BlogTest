<?php

namespace App\Enums;

enum BlogStatus: string
{
    case DRAFT = 'draft';
    case APPROVED = 'approved';
}
