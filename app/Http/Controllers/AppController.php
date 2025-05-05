<?php

namespace App\Http\Controllers;

use App\Services\AssessmentService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function getStarted()
    {
        $filters = array_merge(['access' => 'public'], collectQueryParams(['page']));

        $assessments = app(AssessmentService::class)->pagination(9, $filters, ['user']);
        $categories = app(CategoryService::class)->index();

        return match (Auth::user()->type) {
            'foundation' => view('pages.foundation.index'),
            'participant' => view('pages.participant.index', compact('assessments', 'categories')),
            default => redirect()->route('home'),
        };
    }
}
