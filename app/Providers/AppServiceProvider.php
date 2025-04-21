<?php

namespace App\Providers;

use Midtrans\Config;
use App\Models\Course;
use App\Models\StudentCourse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$clientKey = config('midtrans.client_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;

        View::composer('layouts.backend.admin', function ($view) {
            $user = Auth::user();
            if ($user && $user->role == 'instructor') {
                $courses = Course::where('user_id', $user->id)->where('status', 'approved')->get();
            } elseif ($user && $user->role == 'student') {
                // $courseStudentRegistered = StudentCourse::where('user_id', $user->id)->get();
                // $courses = Course::where('id', $courseStudentRegistered)->get();
                
                $courseStudentRegistered = StudentCourse::where('user_id', $user->id)->pluck('course_id')->toArray();
                
                $courses = Course::whereIn('id', $courseStudentRegistered)->get();
            } else {
                $courses = Course::all();
            }
            $view->with('courses', $courses);
        });
    
    }
}
