<?php

namespace App\Http\Controllers;

use App\DataTables\FoundationResultsDataTable;
use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Models\Assessment;
use App\Models\Result;
use App\Services\AssessmentService;
use App\Services\CategoryService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;

class AssessmentController extends Controller
{
    public function __construct(protected AssessmentService $assessmentService){}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Assessment::class);

        $categories = app(CategoryService::class)->index();

        return view('pages.assessment.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssessmentRequest $request)
    {
        Gate::authorize('create', Assessment::class);

        $this->assessmentService->store($request->validated());

        return redirect()->route('profile.index')->with('success', 'Assemmentt Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment, FoundationResultsDataTable $foundationResultsDataTable)
    {
        Gate::authorize('view', Assessment::class);
        
        $assessment->load('questions', 'results');
        $categories = app(CategoryService::class)->index();
        
        return $foundationResultsDataTable->render('pages.assessment.show', compact('assessment', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAssessmentRequest $request, Assessment $assessment)
    {
        Gate::authorize('update', Assessment::class);

        $this->assessmentService->update($assessment, $request->validated());

        return redirect()->route('assessments.show', $assessment->id)->with('success', 'assessment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        Gate::authorize('delete', Assessment::class);

        $this->assessmentService->destroy($assessment);

        return redirect()->back()->with('success', 'Assessment Deleted Successfully.');
    }

    public function policy(Assessment $assessment)
    {
        Gate::authorize('create', Result::class);

        return view('pages.assessment.policy', compact('assessment'));
    }
}
