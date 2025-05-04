<?php

namespace App\Services;

use App\Models\Question;

class QuestionService extends BaseService
{
    public function __construct()
    {
        parent::__construct(new Question());
    }
}