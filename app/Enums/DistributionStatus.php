<?php

namespace App\Enums;

enum DistributionStatus: string
{
    case CANCELLED = 'cancelled';
    case PENDING = 'pending';
    case FINISHED = 'finished';
}
