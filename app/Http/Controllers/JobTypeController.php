<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
   public function index()
{
    $jobTypes = JobType::latest()->get();
    return view('fontend.job_types.index', compact('jobTypes'));
}

public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $jobType = JobType::create($request->only('name', 'status'));

    return response()->json(['status' => 'success', 'data' => $jobType]);
}

public function edit($id)
{
    $jobType = JobType::findOrFail($id);
    return response()->json($jobType);
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    $jobType = JobType::findOrFail($id);
    $jobType->update($request->only('name', 'status'));

    return response()->json(['status' => 'updated', 'data' => $jobType]);
}

public function destroy($id)
{
    $jobType = JobType::findOrFail($id);
    $jobType->delete();

    return response()->json(['status' => 'deleted']);
}
}