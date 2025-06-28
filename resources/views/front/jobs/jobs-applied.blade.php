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
                <div class="card border-0 shadow mb-4 p-3">
                    <div class="card-body card-form">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h3 class="fs-4 mb-1">My Jobs</h3>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table ">
                                <thead class="bg-light">
                                    <tr>
                                        <th scope="col">Title</th>
                                        <th scope="col">Job Created</th>
                                        <th scope="col">Applicants</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="border-0">
                                    @if($jobs->isNotEmpty())
                                        @foreach($jobs as $job)

                                        <tr class="active">
                                            <td>
                                                <div class="job-name fw-500">{{ $job->title }}</div>
                                                <div class="info1">{{ $job->jobType->name }} . {{ $job->location }}</div>
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M, Y') }}</td>
                                            <td>0 Applications</td>
                                            <td>
                                                <div class="job-status text-capitalize">active</div>
                                            </td>
                                            <td>
                                                <div class="action-dots float-end">
                                                    <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="{{ route('job.details', ['id' => $job->id]) }}"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('job.edit', ['id' => $job->id]) }}"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                        <li><form action="{{ route("job.delete", ["id" => $job->id]) }}" class="delete_job" method="post">@csrf @method('delete')<button class="dropdown-item btn" type="submit"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button></form></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    {{-- <tr class="pending">
                                        <td>
                                            <div class="job-name fw-500".html Developer</div>
                                            <div class="info1">Part-time . Delhi</div>
                                        </td>
                                        <td>13 Aug, 2023</td>
                                        <td>20 Applications</td>
                                        <td>
                                            <div class="job-status text-capitalize">pending</div>
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="expired">
                                        <td>
                                            <div class="job-name fw-500">Full Stack Developer</div>
                                            <div class="info1">Fulltime . Noida</div>
                                        </td>
                                        <td>27 Sep, 2023</td>
                                        <td>278 Applications</td>
                                        <td>
                                            <div class="job-status text-capitalize">expired</div>
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="active">
                                        <td>
                                            <div class="job-name fw-500">Developer for IT company</div>
                                            <div class="info1">Fulltime . Goa</div>
                                        </td>
                                        <td>14 Feb, 2023</td>
                                        <td>70 Applications</td>
                                        <td>
                                            <div class="job-status text-capitalize">active</div>
                                        </td>
                                        <td>
                                            <div class="action-dots float-end">
                                                <a href="#" class="" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="job-detail.html"> <i class="fa fa-eye" aria-hidden="true"></i> View</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-edit" aria-hidden="true"></i> Edit</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="fa fa-trash" aria-hidden="true"></i> Remove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr> --}}
                                </tbody>

                            </table>
                        </div>
                        {{ $jobs->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')
    <script>
        console.log('{{ route("account.profile.update") }}');
        $('#userProfileForm').submit(function(e) {
            e.preventDefault();
            console.log('response may be send');
            $.ajax({
                url: "{{ route('account.profile.update') }}",
                type: "put",
                data: $(this).serializeArray(),
                dataType: "json",
                success: function (response) {
                    console.log(response);
                    if (response.status) {
                        $('#name').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        $('#email').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        window.location.href = "{{ route('account.profile') }}";
                        // $("#message").removeClass().empty();
                        // $('#message').addClass('alert').addClass('alert-success').addClass('alert-dismissable').addClass('fade').addClass('show').text(response.message).append('<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>');
                    } else {
                        if (response.errors.name) {
                            $('#name').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.errors.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                        if (response.errors.email) {
                            $('#email').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.errors.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                        if (response.errors.old_password) {
                            $('#old_password').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.errors.old_password);
                        } else {
                            $('#old_password').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                        if (response.errors.password) {
                            $('#password').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.errors.password[0]);
                            if (response.errors.password[1]) {
                                $('#confirm_password').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.errors.password[1]);
                            } else {
                                $('#confirm_password').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                            }
                        } else {
                            $('#password').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                    }
                }
            });
        });

        $(".delete_job").on("submit", function(e) {
            e.preventDefault();
            if (window.confirm("Are You Sure Do You Want To Delete This Job?")) {
                console.log("This is the delete route : " ,$(this).attr("action"));
                $.ajax({
                    url : $(this).attr("action"),
                    type: "delete",
                    dataType: "json",
                    success: function(response){
                        if (response.status) {
                            console.log('resposne.status');
                            window.location.href = "{{ route('my.jobs') }}";
                        }
                    }
                });
            }
        });

    </script>
@endsection
