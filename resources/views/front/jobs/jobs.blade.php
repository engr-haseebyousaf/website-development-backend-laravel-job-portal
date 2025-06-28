@extends('front.layout.app')
@section('main')
    <section class="section-3 py-5 bg-2 ">
        <div class="container">
            <div class="row">
                <div class="col-6 col-md-10 ">
                    <h2>Find Jobs</h2>
                </div>
                <div class="col-6 col-md-2">
                    <div class="align-end">
                        <select id="sort" class="form-control">
                            <option value="latest" {{ Request::get("sort") == "latest" ? "selected" : "" }}>Latest</option>
                            <option value="oldest" {{ Request::get("sort") == "oldest" ? "selected" : "" }}>Oldest</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row pt-5">
                <div class="col-md-4 col-lg-3 sidebar mb-4">
                    <form id="jobsForm">
                        <div class="card border-0 shadow p-4">
                            <div class="mb-4">
                                <h2>Keywords</h2>
                                <input type="text" value="{{ Request::get('keywords') }}" placeholder="Keywords" id="keywords" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Location</h2>
                                <input type="text" value="{{ Request::get('location') }}" id="location" placeholder="Location" class="form-control">
                            </div>

                            <div class="mb-4">
                                <h2>Category</h2>
                                <select id="category" class="form-control">
                                    <option value="">Select a Category</option>
                                    @forelse($categories as $category)
                                        <option {{ $category->id == Request::get("category") ? "selected" : "" }} value="{{ $category->id }}">{{ $category->name }}</option>
                                    @empty
                                        <option value="">No Category Found</option>
                                    @endforelse
                                </select>
                            </div>

                            <div class="mb-4">
                                <h2>Job Type</h2>
                                @forelse($jobTypes as $jobType)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="job_type" id="job-type-{{ $jobType->id }}"
                                            type="checkbox" value="{{ $jobType->id }}" {{ in_array($jobType->id, $jobTypeArr) ? "checked" : "" }} id="">
                                        <label class="form-check-label"
                                            for="job-type-{{ $jobType->id }}">{{ $jobType->name }}</label>
                                    </div>
                                @empty
                                    <div class="form-check mb-2">
                                        <h4>No Job Type Found</h4>
                                    </div>
                                @endforelse
                            </div>

                            <div class="mb-4">
                                <h2>Experiance</h2>
                                <input type="text" value="{{ Request::get('experiance') }}" id="experiance" placeholder="Enter Experiance" class="form-control">
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary btn-lg" type="submit">Search</button>
                            </div>

                        </div>
                    </form>
                </div>
                <div class="col-md-8 col-lg-9 ">
                    <div class="job_listing_area">
                        <div class="job_lists">
                            <div class="row">
                                @forelse($jobs as $job)
                                    <div class="col-md-4">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">{{ $job->title }}</h3>
                                                <p>{{ Str::words($job->description, 10, "...") }}</p>
                                                <div class="bg-light p-3 border">
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-map-marker"></i></span>
                                                        <span class="ps-1">{{ $job->location }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-clock-o"></i></span>
                                                        <span class="ps-1">{{ $job->jobType->name }}</span>
                                                    </p>
                                                    <p class="mb-0">
                                                        <span class="fw-bolder"><i class="fa fa-usd"></i></span>
                                                        <span class="ps-1">{{ $job->salary }} PA</span>
                                                    </p>
                                                </div>

                                                <div class="d-grid mt-3">
                                                    <a href="{{ route('job.details', $job->id) }}" class="btn btn-primary btn-lg">Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-md-4">
                                        <div class="card border-0 p-3 shadow mb-4">
                                            <div class="card-body">
                                                <h3 class="border-0 fs-5 pb-2 mb-0">No Job Found</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse


                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @section('extra_js')
        <script>
            const sort = $("#sort");
            $("#jobsForm").on("submit", function(e){
                e.preventDefault();
                let url = "{{ route('jobs') }}?";
                const keywords = $("#keywords").val();
                const location = $("#location").val();
                const category = $("#category").val();
                const experiance = $("#experiance").val();
                const sort = $("#sort").val();
                const checkedJobTypes = $("input:checkbox[name='job_type']:checked").map(function(){
                    return $(this).val();
                }).get();
                url += "sort=" + sort;
                if (keywords != "") {
                    url += "&keywords=" + keywords;
                }
                if (location != "") {
                    url += "&location=" + location;
                }
                if (category != "") {
                    url += "&category=" + category;
                }
                if (experiance != "") {
                    url += "&experiance=" + experiance;
                }
                if (checkedJobTypes.length > 0) {
                    url += "&jobType=" + checkedJobTypes;
                }
                window.location.href = url;
                console.log(url);
            });
            sort.on("change", function(){
                $("#jobsForm").submit();
            });
        </script>
    @endsection
@endsection
