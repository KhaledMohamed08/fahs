<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAssessmentRequest;
use App\Http\Requests\UpdateAssessmentRequest;
use App\Models\Assessment;
use App\Services\AssessmentService;
use App\Services\CategoryService;
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
        $categories = app(CategoryService::class)->index();

        return view('pages.assessment.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAssessmentRequest $request)
    {
        $this->assessmentService->store($request->validated());

        return redirect()->route('profile.index')->with('success', 'Assemmentt Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        $assessment->load('questions');
        
        return view('pages.assessment.show', compact('assessment'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        $this->assessmentService->destroy($assessment);

        return redirect()->back()->with('success', 'Assessment Deleted Successfully.');
    }
}
