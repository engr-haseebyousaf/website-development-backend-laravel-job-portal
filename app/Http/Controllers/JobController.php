<?php

namespace App\Http\Controllers;

use App\Mail\NotificationMail;
use App\Models\AppliedJob;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobsApplied;
use App\Models\JobType;
use App\Models\SavedJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use function PHPUnit\Framework\isEmpty;

class JobController extends Controller
{
    public function postJob() {
        $categories = Category::orderBy('name')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name')->where('status', 1)->get();
        return view('front.jobs.post-job', ['categories' => $categories, 'jobTypes' => $jobTypes]);
    }

    public function createJob(Request $request) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:50',
            'category' => 'required|exists:categories,id',
            'job_nature' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'experiance' => 'required',
            'company_name' => 'required',
            'company_location' => 'required',
            'company_website' => 'required|url',
        ]);
        if ($validator->passes()) {
            $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->job_nature;
            $job->user_id = Auth::user()->id;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benifits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experiance = $request->experiance;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();
            // dd($job);
            session()->flash('success', 'Job Created Successfully');
            return response([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function myJobs() {
        $jobs = Job::orderBy('created_at', 'DESC')->where('user_id', Auth::user()->id)->with('jobType')->paginate(10);
        // dd($jobs);
        return view('front.jobs.my-jobs', compact(['jobs']));
    }
    public function editJob($id){
        $job = Job::where([
            'id' => $id
        ])->find($id);
        if ($job === null) {
            abort(404);
        }
        $categories = Category::orderBy('name')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name')->where('status', 1)->get();
        return view('front.jobs.edit-job', compact('job', 'categories', 'jobTypes'));
    }
    public function updateJob(Request $request, $id) {
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5|max:50',
            'category' => 'required|exists:categories,id',
            'job_nature' => 'required|exists:job_types,id',
            'vacancy' => 'required|integer',
            'location' => 'required',
            'description' => 'required',
            'experiance' => 'required',
            'company_name' => 'required',
            'company_location' => 'required',
            'company_website' => 'required|url',
        ]);
        if ($validator->passes()) {
            $job = Job::where("user_id", Auth::user()->id)->find($id);
            // dd($job);
            // $job = new Job();
            $job->title = $request->title;
            $job->category_id = $request->category;
            $job->job_type_id = $request->job_nature;
            $job->vacancy = $request->vacancy;
            $job->salary = $request->salary;
            $job->location = $request->location;
            $job->description = $request->description;
            $job->benifits = $request->benefits;
            $job->responsibility = $request->responsibility;
            $job->qualifications = $request->qualifications;
            $job->keywords = $request->keywords;
            $job->experiance = $request->experiance;
            $job->company_name = $request->company_name;
            $job->company_location = $request->company_location;
            $job->company_website = $request->company_website;
            $job->save();
            // dd($job);
            session()->flash('success', 'Job Updated Successfully');
            return response([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function deleteJob($id){
        $job = Job::where("id", $id)->where("user_id", Auth::user()->id)->first();
        if($job == null) {
            return response([
                "status" => false,
                "errors" => ['error' => "Either Job Not Exists"]
            ]);

        } else {
            Job::where("id", $id)->where("user_id", Auth::user()->id)->delete();
            session()->flash('success', 'Job Deleted Successfully');
            return response([
                "status" => true,
                "errors" => []
            ]);
        }
    }
    public function jobs(Request $request){
        $categories = Category::where("status", 1)->get();
        $jobTypes = JobType::where("status", 1)->get();
        $jobs = Job::where([
            "status" => 1,
        ]);
        if ($request->filled("keywords")) {
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere("keywords", "like", "%" . $request->keywords . "%")
                ->orWhere("title","like", "%" . $request->title . "%");
            });
        }
        if ($request->filled('location')) {
            $jobs = $jobs->where(function($query) use ($request){
                $query->orWhere("location", "like", "%" . $request->location . "%")
                ->orWhere("company_location","like", "%" . $request->location . "%");
            });
        }
        if ($request->filled('category')){
            $jobs = $jobs->where("category_id", $request->category);
        }
        if ($request->filled('experiance')){
            $jobs = $jobs->where("experiance", $request->experiance);
        }
        $jobTypeArr = [];
        if ($request->filled('jobType')) {
            $jobTypeArr = explode(",", $request->jobType);
            // dd($jobTypeArr, $request->jobType);
            $jobs = $jobs->whereIn("job_type_id", $jobTypeArr);
        }
        $jobs = $jobs->with("jobType");
        if ($request->sort == "oldest" || empty($request->sort)) {
            $jobs = $jobs->orderBy("created_at", "ASC");
        } else if ($request->sort == "latest") {
            $jobs = $jobs->orderByDesc("created_at");
        }

        $jobs = $jobs->get();
        return view("front.jobs.jobs", compact("categories", "jobTypes", "jobs", "jobTypeArr"));
    }
    // show the job details view
    public function jobDetails(Request $request){
        $job = Job::where([
            "id" => $request->id,
            "status" => 1,
        ])
        ->with(["jobType", "categories"])
        ->find($request->id);
        if ($job == null) {
            abort(404, "Job Not Found");
        }
        $savedJob = SavedJob::where([
            "user_id" => Auth::user()->id,
            "job_id" => $request->id
        ])->get()->count();

        $jobApplications = AppliedJob::with("user")
        ->get();
        // dd($jobApplications);
        return view("front.jobs.job-details", compact("job", "savedJob", "jobApplications"));
    }

    // apply job
    public function jobApply(Request $request){
        $id = $request->id;
        $job = Job::where("id", $id)->first();

        // check if the job exists
        if ($job == null) {
            $message = "Job Does Not Exists";
            session()->flash("fail", $message);
            return response([
                "status" => false,
                "message" => $message
            ]);
        }


        // check if the user is applying his/her own created job
        $employer_id = $job->user_id;
        if ($employer_id == Auth::user()->id) {
            $message = "Cannot Apply Your Own Job";
            session()->flash("fail", $message);
            return response([
                "status" => false,
                "message" => $message,
            ]);
        }

        // check if the user already applied to job
        $appliedJob = AppliedJob::where("job_id", $id)->first();
        if ($appliedJob != null) {
            $message = "Already Applied Job";
            session()->flash("warn", $message);
            return response([
                "status" => false,
                "message" => $message,
            ]);
        }

        // successfully applied job
        $jobsApplied = new AppliedJob();
        $jobsApplied->user_id = Auth::user()->id;
        $jobsApplied->job_id = $id;
        $jobsApplied->employer_id = $employer_id;
        $jobsApplied->save();
        $message = "Successfully Applied Job";
        session()->flash("success", $message);
        $employer = User::where("id", $employer_id)->first();
        $user = Auth::user();
        $details = [
            "employer" => $employer,
            "user" => $user,
            "job" => $job
        ];
        Mail::to($employer->email)->send(new NotificationMail($details));
        return response([
            "status" => true,
            "message" => $message
        ]);
    }
    // jobs applied page view
    public function jobsApplied() {
        $appliedJobs = AppliedJob::where('user_id', Auth::user()->id)->with(['job', 'job.jobType', 'job.applications'])->paginate(10);
        // dd($appliedJobs);
        return view("front.jobs.jobs-applied", compact('appliedJobs'));
    }
    public function jobApplicationDelete(Request $request) {
        $jobApplication = AppliedJob::where([
            'id'=> $request->id,
            'user_id' => Auth::user()->id
        ]);
        if ($jobApplication == null) {
            session()->flash('fail', "Job Application Not Found");
            return response([
                "status" => false,
                'message' => "Job Application Not Found"
            ]);
        }
        AppliedJob::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])->delete();
        session()->flash('success', "Successfully Removed Job Application");
        return response([
            'status' => true,
            "Successfully Removed Job Application"
        ]);
    }

    public function saveJob(Request $request) {
        // dd($request->id);
        $job = Job::where("id", $request->id)->get();
        if($job == null) {
            session()->flash('fail', "Job Does Not Exist");
            return response([
                "status" => false
            ]);
        }
        $count = SavedJob::where([
            "job_id" => $request->id,
            "user_id" => Auth::user()->id
        ])->get();
        if ($count->count() > 0) {
            session()->flash('warn', "Job Already Saved");
            return response([
                "status" => false
            ]);
        }
        $savedJob = new SavedJob();
        $savedJob->user_id = Auth::user()->id;
        $savedJob->job_id = $request->id;
        $savedJob->save();
        session()->flash('success', "Job Saved Successfully");
            return response([
                "status" => true
            ]);
    }

    // saved jobs *******
    public function savedJobs() {
        $savedJobs = SavedJob::
        where('user_id', Auth::user()->id)
        ->with(['job', 'job.jobType', 'job.applications'])
        ->paginate(10);
        // dd($appliedJobs);
        return view("front.jobs.saved-jobs", compact('savedJobs'));
    }
    public function unsaveJob(Request $request) {
        $savedJob = SavedJob::where([
            'id'=> $request->id,
            'user_id' => Auth::user()->id
        ]);
        if ($savedJob == null) {
            session()->flash('fail', "Job Not Saved");
            return response([
                "status" => false,
                'message' => "Job Not Saved"
            ]);
        }
        SavedJob::where([
            'id' => $request->id,
            'user_id' => Auth::user()->id
        ])->delete();
        session()->flash('success', "Job Un-Saved successfully");
        return response([
            'status' => true,
            "Job Un-Saved successfully"
        ]);
    }
}
