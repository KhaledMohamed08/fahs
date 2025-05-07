<?php

namespace App\Http\Controllers;

use App\DataTables\FoundationAssessmentsDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index(FoundationAssessmentsDataTable $dataTable)
    {
        $user = Auth::user();
        $assessments = $user->assessments;
        
        return match ($user->type) {
            'foundation' => $dataTable->render('pages.foundation.profile', compact('assessments')),
            // 'foundation' => view('pages.foundation.profile', compact('assessments')),
            'participant' => view('pages.participant.profile'),
            default => redirect()->route('home'),
        };
    }
}
