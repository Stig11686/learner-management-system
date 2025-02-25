<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cohort;
use App\Models\Course;

class CohortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cohorts = Cohort::with('learners')->get();

        return view('cohorts.index', compact('cohorts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        
        return view('cohorts.create', [
            'courses' => $courses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $name = $request->input('name');
        $courseId = $request->input('course');

        Cohort::create([
            'name' => $name,
            'course_id' => $courseId,
        ]);

        return redirect()->route('cohorts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('cohorts.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
