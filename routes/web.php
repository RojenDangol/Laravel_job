<?php

use App\Models\Job;
use App\Mail\JobPosted;
use App\Jobs\TranslateJob;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterUserController;

Route::get('test', function () {
    // Mail::to('rojendangol1@gmail.com')->send(new JobPosted());
    // dispatch(function(){
    //     logger('hello form the queue!');
    // })->delay(5);
    $job = Job::first();
    TranslateJob::dispatch($job);
    return 'Done';
});

Route::view('/', 'home');
Route::view('/contact', 'contact');

Route::controller(JobController::class)->group(function(){
    Route::get('/jobs', 'index');
    Route::get('/jobs/create', 'create');
    Route::get('/jobs/{job}', 'show');
    Route::post('/jobs', 'store')->middleware('auth');

    Route::get('/jobs/{job}/edit', 'edit')
    ->middleware('auth')
    ->can('edit','job');//last job is the wildcard pass in the route{job}

    Route::patch('/jobs/{job}', 'update')
    ->middleware('auth')
    ->can('edit','job');

    Route::delete('/jobs/{job}', 'destroy')
    ->middleware('auth')
    ->can('edit','job');
});

// Route::resource('jobs', JobController::class)->execpt(['index','show'])->middleware('auth');


Route::get('/register',[RegisterUserController::class, 'create']);
Route::post('/register',[RegisterUserController::class, 'store']);

Route::get('/login',[SessionController::class, 'create'])->name('login');
Route::post('/login',[SessionController::class, 'store']);
Route::post('/logout',[SessionController::class, 'destroy']);