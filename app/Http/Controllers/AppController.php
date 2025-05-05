<?php

namespace App\Http\Controllers;

use App\Services\AssessmentService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Auth;

class AppController extends Controller
{
    public function __construct(protected AssessmentService $assessmentService) {}

    public function getStarted()
    {
        $categories = app(CategoryService::class)->index();
        $paginationPerPage = 12;

        $filters = array_merge(
            ['access' => 'public'],
            collectQueryParams(['page', 'search'])
        );

        $assessments = request()->filled('search')
            ? $this->assessmentService->scoutSearch(request('search'), [], ['user'], $paginationPerPage)
            : $this->assessmentService->pagination($paginationPerPage, $filters, ['user']);

        return match (Auth::user()->type) {
            'foundation' => view('pages.foundation.index'),
            'participant' => view('pages.participant.index', compact('assessments', 'categories')),
            default => redirect()->route('home'),
        };
    }
}
