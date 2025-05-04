<?php

namespace App\Services;

use App\Models\Assessment;

class AssessmentService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Assessment());
    }
}