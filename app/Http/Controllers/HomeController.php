<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::where('status', 1)->take(8)->get();
        $allCategories = Category::where('status', 1)->get();
        $featuredJobs = Job::where(["isFeatured"=> 1, "user_id" => Auth::user()->id])
        ->with("jobType")
        ->orderByDesc('created_at')->
        take(6)->
        get();
        $latestJobs = Job::where("user_id" , Auth::user()->id)
        ->with("jobType")
        ->orderByDesc('created_at')->
        take(6)->
        get();
        return view('front.home', compact('categories', "featuredJobs", "latestJobs", "allCategories"));
    }
}
