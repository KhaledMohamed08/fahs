<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultRequest;
use App\Http\Requests\UpdateResultRequest;
use App\Models\Assessment;
use App\Models\Result;
use App\Services\ResultService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultController extends Controller
{
    public function __construct(protected ResultService $resultService) {}
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
    public function create(Assessment $assessment)
    {
        // if (session('assessment_start')) {
        //     abort(403, 'You cannot start a new assessment while one is already in progress.');
        // }

        $assessment->load('questions');

        return view('pages.result.create', compact('assessment'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultRequest $request)
    {
        session()->forget([
            "assessment_start_time_{$request['assessment_id']}",
            "assessment_start"
        ]);

        $result = $this->resultService->store($request->validated());

        return redirect()->route('results.review.submit', $result->id)->with('result', 'submit successfullt');
    }

    /**
     * Display the specified resource.
     */
    public function show(Result $result)
    {
        if (Auth::user()->type === 'foundation') {
            $this->resultService->updateResultStatus($result);
        }

        $result->load('user', 'assessment', 'details');

        return view('pages.result.show-foundation', compact('result'));
    }

    public function showForParticipant(Result $result)
    {
        return view('pages.result.show-participant', compact('result'));
    }

    public function resultDetailsForParticipant(Result $result)
    {
        return view('pages.result.participant-details', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Result $result)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultRequest $request, Result $result)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Result $result)
    {
        //
    }

    public function submitReview(Result $result)
    {
        return view('pages.result.result-submit', compact('result'));
    }

    public function submitResult(Request $request, Result $result)
    {
        if ($result->status === 'done')
            abort(403, 'This result has already been submitted and cannot be modified.');

        $data = $request->validate([
            'score' => 'required|array',
        ]);

        $this->resultService->submitResult($data, $result);

        return redirect()->route('assessments.show', $result->assessment->id)->with('success', 'Result Submited Successfully.');
    }
}
