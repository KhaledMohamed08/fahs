<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        return match (Auth::user()->type) {
            'foundation' => view('pages.foundation.profile'),
            'participant' => view('pages.participant.profile'),
            default => redirect()->route('home'),
        };
    }
}
