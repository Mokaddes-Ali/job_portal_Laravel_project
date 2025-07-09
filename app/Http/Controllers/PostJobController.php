<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostJob;
use App\Models\Category;
use App\Models\JobType;

class PostJobController extends Controller{


   public function index()
{
    $jobs = PostJob::with(['category', 'jobType'])->latest()->get();
    $categories = Category::all();
    $jobTypes = JobType::all();
    return view('fontend.jobs.index', compact('jobs', 'categories', 'jobTypes'));
}

    public function create()
    {
        $categories = Category::all();
        $jobTypes = JobType::all();
        return view('fontend.jobs.create', compact('categories', 'jobTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'job_nature' => 'required',
            'vacancy' => 'required|integer|min:1',
            'location' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'company_name' => 'required',
        ]);

        PostJob::create($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job Created Successfully!');
    }

    public function show(PostJob $job)
    {
        return view('fontend.jobs.show', compact('job'));
    }

    public function edit(PostJob $job)
    {
        $categories = Category::all();
        $jobTypes = JobType::all();
        return view('fontend.jobs.edit', compact('job', 'categories', 'jobTypes'));
    }

    public function update(Request $request, PostJob $job)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'job_type_id' => 'required|exists:job_types,id',
            'job_nature' => 'required',
            'vacancy' => 'required|integer|min:1',
            'location' => 'required',
            'description' => 'required',
            'keywords' => 'required',
            'company_name' => 'required',
        ]);

        $job->update($request->all());

        return redirect()->route('jobs.index')->with('success', 'Job Updated Successfully!');
    }

    public function destroy(PostJob $job)
    {
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job Deleted Successfully!');
    }
}
