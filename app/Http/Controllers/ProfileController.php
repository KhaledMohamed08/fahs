<?php

namespace App\Http\Controllers;

use App\DataTables\FoundationAssessmentsDataTable;
use App\DataTables\ParticipantResultsDataTable;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(FoundationAssessmentsDataTable $foundationDataTable, ParticipantResultsDataTable $participantDataTable)
    {
        $user = Auth::user();
        $assessments = $user->assessments;
        $assessmentsCount = $assessments->count();
        $assessmentsResultsCount = $assessments->filter(fn($assessment) => $assessment->results->isNotEmpty())->count();
        $assessmentsResultsUsersCount = $assessments
            ->flatMap->results
            ->pluck('user_id')
            ->unique()
            ->count();

        $results = $user->results;

        return match ($user->type) {
            'foundation' => $foundationDataTable->render('pages.foundation.profile', compact(
                'assessmentsCount',
                'assessmentsResultsCount',
                'assessmentsResultsUsersCount',
            )),
            'participant' => $participantDataTable->render('pages.participant.profile', compact('results')),
            default => redirect()->route('home'),
        };
    }
}
