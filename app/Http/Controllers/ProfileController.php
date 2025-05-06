<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $assessments = $user->assessments;
        $assessments->load('category');
        
        return match ($user->type) {
            'foundation' => view('pages.foundation.profile', compact('assessments')),
            'participant' => view('pages.participant.profile'),
            default => redirect()->route('home'),
        };
    }
}
