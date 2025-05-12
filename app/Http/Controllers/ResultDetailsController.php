<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreResultDetailsRequest;
use App\Http\Requests\UpdateResultDetailsRequest;
use App\Models\ResultDetails;
use App\Services\ResultDetailsService;

class ResultDetailsController extends Controller
{
    public function __construct(protected ResultDetailsService $resultDetailsService){}
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreResultDetailsRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ResultDetails $resultDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ResultDetails $resultDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateResultDetailsRequest $request, ResultDetails $resultDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ResultDetails $resultDetails)
    {
        //
    }
}
