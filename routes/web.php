<?php

use Illuminate\Support\Facades\Route;
use App\Models\Job;

Route::get('/', function () {
    return view('home');
});

// index:displays all job
Route::get('/jobs', function(){
    $jobs = Job::with('employer')->latest()->simplePaginate(3);
    
    return view('jobs.index', [               
        'jobs' =>  $jobs
    ]);
});

// create job
Route::get('/jobs/create', function () {
    return view('jobs.create');
});

// Show job
Route::get('/jobs/{id}', function($id){

    $job = Job::find($id);

    // dd($jobs);
    return view('jobs.show', ['job' => $job]);
});

// Store job in db
Route::post('/jobs', function () {
    // dd('Hello from post request');
    // validating the form request
    request()->validate([
        'title'=>['required', 'min:3'],
        'salary'=>['required'],
    ]);

    Job::create([
        'title'=> request('title'),
        'salary'=> request('salary'),
        'employer_id'=> 1,
    ]);

    return redirect('/jobs'); 

});

// Edit job
Route::get('/jobs/{id}/edit', function($id){
    $job = Job::find($id);

    return view('jobs.edit', ['job' => $job]);
});

// Update job
Route::patch('/jobs/{id}', function($id){
    // validate
    request()->validate([
        'title'=>['required', 'min:3'],
        'salary'=>['required'],
    ]);

    // updaate the job
    $job = Job::findOrFail($id);

    $job->update([
        'title'=>request('title'),
        'salary'=>request('salary'),
    ]);

    return redirect('jobs/'.$job->id);
});

// Destroy job
Route::delete('/jobs/{id}', function($id){

    // delete the job
    $job = Job::findOrFail($id);
    $job->delete();

    return redirect('/jobs');
    
});

Route::get('/contact', function(){
    return view('contact');
});