@extends('front.layout.app')
@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Account Settings</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    {{-- including sidebar --}}
                    @include('front.layout.sidebar')
                </div>
                <div class="col-lg-9">
                    {{-- include message component --}}
                    @include('front.component.message')
                    <form id="createJobForm" method="post">
                        @csrf
                        <div class="card border-0 shadow mb-4 ">
                            <div class="card-body card-form p-4">
                                <h3 class="fs-4 mb-1">Job Details</h3>
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Title<span class="req">*</span></label>
                                        <input type="text" placeholder="Job Title" id="title" name="title"
                                            class="form-control">
                                            <small></small>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="" class="mb-2">Category<span class="req">*</span></label>
                                        <select name="category" id="category" class="form-control">
                                            <option value="">Select a Category</option>
                                            @if($categories->isNotEmpty())
                                                @foreach($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <label for="" class="mb-2">Job Nature<span class="req">*</span></label>
                                        <select class="form-select" name="job_nature">
                                            <option value="">Select Job Nature</option>
                                            @if($jobTypes->isNotEmpty())
                                                @foreach($jobTypes as $jobType)
                                                    <option value="{{ $jobType->id }}">{{ $jobType->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <small></small>
                                    </div>
                                    <div class="col-md-6  mb-4">
                                        <label for="vacancy" class="mb-2">Vacancy<span class="req">*</span></label>
                                        <input type="number" min="1" placeholder="Vacancy" id="vacancy"
                                            name="vacancy" class="form-control">
                                            <small></small>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="salary" class="mb-2">Salary</label>
                                        <input type="text" placeholder="Salary" id="salary" name="salary"
                                            class="form-control">
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="location" class="mb-2">Location<span class="req">*</span></label>
                                        <input type="text" placeholder="location" id="location" name="location"
                                            class="form-control">
                                            <small></small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="description" class="mb-2">Description<span class="req">*</span></label>
                                    <textarea class="form-control" name="description" id="description" cols="5" rows="5"
                                        placeholder="Description"></textarea>
                                        <small></small>
                                </div>
                                <div class="mb-4">
                                    <label for="benefits" class="mb-2">Benefits</label>
                                    <textarea class="form-control" name="benefits" id="benefits" cols="5" rows="5" placeholder="Benefits"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="responsibility" class="mb-2">Responsibility</label>
                                    <textarea class="form-control" name="responsibility" id="responsibility" cols="5" rows="5"
                                        placeholder="Responsibility"></textarea>
                                </div>
                                <div class="mb-4">
                                    <label for="qualifications" class="mb-2">Qualifications</label>
                                    <textarea class="form-control" name="qualifications" id="qualifications" cols="5" rows="5"
                                        placeholder="Qualifications"></textarea>
                                </div>




                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="keywords" class="mb-2">Keywords</label>
                                            <input type="text" placeholder="keywords" id="keywords" name="keywords"
                                                class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label for="experiance" class="mb-2">Years Of Experiance<span class="req">*</span></label>
                                            <input type="number" placeholder="experiance" id="experiance" name="experiance"
                                                class="form-control">
                                                <small></small>
                                        </div>
                                    </div>
                                </div>

                                <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                <div class="row">
                                    <div class="mb-4 col-md-6">
                                        <label for="company_name" class="mb-2">Name<span class="req">*</span></label>
                                        <input type="text" placeholder="Company Name" id="company_name"
                                            name="company_name" class="form-control">
                                            <small></small>
                                    </div>

                                    <div class="mb-4 col-md-6">
                                        <label for="company_location" class="mb-2">Location</label>
                                        <input type="text" placeholder="Company Location" id="company_location" name="company_location"
                                            class="form-control">
                                            <small></small>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="company_website" class="mb-2">Website</label>
                                    <input type="text" placeholder="Company Website" id="company_website" name="company_website"
                                        class="form-control">
                                        <small></small>
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Save Job</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('extra_js')
    <script>
        $('#createJobForm').submit(function(e) {
            e.preventDefault();
            // console.log($(this).serializeArray());
            // return false;
            $.ajax({
                url: "{{ route('job.create') }}",
                type: "post",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function(response) {
                    console.log(response);
                    if (response.status) {
                        $('#title').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#category').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#job_nature').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#vacancy').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#location').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#description').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#experiance').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#company_name').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#company_location').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        $('#company_website').removeClass('is-invalid').siblings('small').removeClass(
                            'invalid-feedback').text('');
                        window.location.href = "{{ route('my.jobs') }}";
                        // $("#message").removeClass().empty();
                        // $('#message').addClass('alert').addClass('alert-success').addClass('alert-dismissable').addClass('fade').addClass('show').text(response.message).append('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                    } else {
                        if (response.errors.title) {
                            $('#title').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.title);
                        }
                        if (response.errors.category) {
                            $('#category').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.category);
                        }
                        if (response.errors.job_nature) {
                            $('#job_nature').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.job_nature);
                        }
                        if (response.errors.vacancy) {
                            $('#vacancy').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.vacancy);
                        }
                        if (response.errors.location) {
                            $('#location').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.location);
                        }
                        if (response.errors.description) {
                            $('#description').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.description);
                        }
                        if (response.errors.experiance) {
                            $('#experiance').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.experiance);
                        }
                        if (response.errors.company_name) {
                            $('#company_name').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.company_name);
                        }
                        if (response.errors.company_location) {
                            $('#company_location').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.company_location);
                        }
                        if (response.errors.company_website) {
                            $('#company_website').addClass('is-invalid').siblings('small').addClass(
                                'invalid-feedback').text(response.errors.company_website);
                        }
                    }
                },
                error : function(xhr){
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
