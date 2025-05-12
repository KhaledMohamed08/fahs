<?php

namespace App\Services;

use App\Models\ResultDetails;

class ResultDetailsService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new ResultDetails());
    }
}