@extends('front.layout.app')
@section('main')
    <section class="section-4 bg-2">
        <div class="container pt-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('jobs') }}"><i class="fa fa-arrow-left"
                                        aria-hidden="true"></i> &nbsp;Back to Jobs</a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <div class="container job_details_area">
            <div class="row pb-5">
                <div class="col-md-8">
                    @include('front.component.message')
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg d-flex justify-content-between">
                                <div class="jobs_left d-flex align-items-center">

                                    <div class="jobs_conetent">
                                        <a href="#">
                                            <h4>{{ $job->title }}</h4>
                                        </a>
                                        <div class="links_locat d-flex align-items-center">
                                            <div class="location">
                                                <p> <i class="fa fa-map-marker"></i> {{ $job->location }}</p>
                                            </div>
                                            <div class="location">
                                                <p> <i class="fa fa-clock-o"></i> {{ $job->jobType->name }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jobs_right">
                                    <div class="apply_now">
                                        <button class="heart_mark {{ $savedJob > 0 ? 'job_saved' : '' }}" href="#"
                                            onclick="saveJob({{ $job->id }})"> <i class="fa fa-heart-o"
                                                aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="descript_wrap white-bg">
                            <div class="single_wrap">
                                <h4>Job description</h4>
                                <p>{!! nl2br($job->description) !!}</p>
                            </div>
                            @if (!empty($job->responsibility))
                                <div class="single_wrap">
                                    <h4>Responsibility</h4>
                                    <p>{!! nl2br($job->responsibility) !!}</p>
                                </div>
                            @endif
                            @if (!empty($job->qualifications))
                                <div class="single_wrap">
                                    <h4>Qualifications</h4>
                                    <p>{!! nl2br($job->qualifications) !!}</p>
                                </div>
                            @endif
                            @if (!empty($job->benifits))
                                <div class="single_wrap">
                                    <h4>Benefits</h4>
                                    <p>{!! nl2br($job->benifits) !!}</p>
                                </div>
                            @endif
                            <div class="border-bottom"></div>
                            <div class="pt-3 text-end">

                                @if (Auth::check())
                                    <button class="btn btn-secondary {{ $savedJob > 0 ? 'job_saved' : '' }}"
                                        onclick="saveJob({{ $job->id }})">Save</button>
                                @else
                                    <a href="Javascript:void(0);" class="btn btn-primary disabled">Login To Save</a>
                                @endif
                                @if (Auth::check())
                                    <a href="#" id="applyJob" data-id="{{ $job->id }}"
                                        data-url="{{ route('job.apply', ['id' => $job->id]) }}"
                                        data-curr-url="{{ url()->current() }}" class="btn btn-primary">Apply</a>
                                @else
                                    <a href="Javascript:void(0);" class="btn btn-primary disabled">Login To Apply</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow border-0">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Job Summery</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Published on:
                                        <span>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</span></li>
                                    <li>Vacancy: <span>{{ $job->vacancy }}</span></li>
                                    <li>Salary: <span>{{ $job->salary }}</span></li>
                                    <li>Location: <span>{{ $job->location }}</span></li>
                                    <li>Job Nature: <span> {{ $job->jobType->name }}</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow border-0 my-4">
                        <div class="job_sumary">
                            <div class="summery_header pb-1 pt-4">
                                <h3>Company Details</h3>
                            </div>
                            <div class="job_content pt-3">
                                <ul>
                                    <li>Name: <span>{{ $job->company_name }}</span></li>
                                    <li>Locaion: <span>{{ $job->company_location }}</span></li>
                                    <li>Webite: <span><a href="{{ $job->company_website }}">Visit Website</a></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if(Auth::user()->id == $job->user_id)
<div class="row pb-5">
                <div class="col-md-8">
                    <div class="card shadow border-0">
                        <div class="job_details_header">
                            <div class="single_jobs white-bg">

                                <div class="jobs_conetent">
                                    <h4>Job Applicants</h4>
                                    <div class="table-responsive w-100">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Contact</th>
                                                    <th scope="col">Applied At</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($jobApplications as $jobApplication)
                                                    <tr class="">
                                                        <td scope="row">{{ $jobApplication->user->name }}</td>
                                                        <td>{{ $jobApplication->user->email }}</td>
                                                        <td>{{ $jobApplication->user->mobile }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($jobApplication->created_at)->format("d M, Y") }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </section>
@endsection
@section('extra_js')
    <script>
        function saveJob(id) {
            $.ajax({
                type: "post",
                data: {
                    id: id
                },
                url: "{{ route('job.save') }}",
                dataType: "json",
                success: function(response) {
                    window.location.href = "{{ url()->current() }}";
                }
            });
        }
        $("#applyJob").on("click", function(e) {
            e.preventDefault();
            if (confirm("Are You Sure You Want To Apply This Job")) {
                const id = $(this).attr("data-id");
                const url = $(this).attr("data-url");
                // window.alert(id);
                $.ajax({
                    type: "post",
                    url: url,
                    data: {
                        id: id
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);
                        window.location.href = "{{ url()->current() }}";
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR.responseText);
                    }
                });
            }
        });
    </script>
@endsection
