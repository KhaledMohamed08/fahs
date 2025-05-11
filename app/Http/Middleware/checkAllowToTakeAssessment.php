<?php

namespace App\Http\Middleware;

use App\Models\Assessment;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class checkAllowToTakeAssessment
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $assessment = $request->route('assessment');
        $user = Auth::user();

        $alreadySubmitted = $user->results
            ->where('assessment_id', $assessment->id)
            ->first();

        if ($alreadySubmitted) {
            return redirect()->route("get.started")->with('error', 'You have already submitted this assessment.');
            // return abort(401, "You have already submitted this assessment.");
        }

        return $next($request);
    }
}
