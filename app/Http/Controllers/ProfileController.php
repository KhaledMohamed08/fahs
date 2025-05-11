<?php

namespace App\Http\Controllers;

use App\DataTables\FoundationAssessmentsDataTable;
use App\DataTables\ParticipantResultsDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(FoundationAssessmentsDataTable $foundationDataTable, ParticipantResultsDataTable $participantDataTable)
    {
        $user = Auth::user();
        $assessments = $user->assessments;
        $results = $user->results;
        
        return match ($user->type) {
            'foundation' => $foundationDataTable->render('pages.foundation.profile', compact('assessments')),
            // 'foundation' => view('pages.foundation.profile', compact('assessments')),
            'participant' => $participantDataTable->render('pages.participant.profile', compact('results')),
            // 'participant' => view('pages.participant.profile', compact('results')),
            default => redirect()->route('home'),
        };
    }
}
