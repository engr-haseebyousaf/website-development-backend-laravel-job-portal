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
                                    <h3 class="fs-4 mb-1">Jobs Applied</h3>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table ">
                                    <thead class="bg-light">
                                        <tr>
                                            <th scope="col">Title</th>
                                            <th scope="col">Application Date</th>
                                            <th scope="col">Applicants</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody class="border-0">
                                        @if ($savedJobs->isNotEmpty())
                                            @foreach ($savedJobs as $savedJob)
                                                <tr class="active">
                                                    <td>
                                                        <div class="job-name fw-500">{{ $savedJob->job->title }}</div>
                                                        <div class="info1">{{ $savedJob->job->jobType->name }} .
                                                            {{ $savedJob->job->location }}</div>
                                                    </td>
                                                    <td>{{ \Carbon\Carbon::parse($savedJob->created_at)->format('d M, Y') }}
                                                    </td>
                                                    <td>{{ $savedJob->job->applications->count() }} Applications</td>
                                                    <td>
                                                        <div class="job-status text-capitalize">active</div>
                                                    </td>
                                                    <td>
                                                        <div class="action-dots float-end">
                                                            <a href="#" class="" data-bs-toggle="dropdown"
                                                                aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('job.details', ['id' => $savedJob->job_id]) }}">
                                                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                                        View</a></li>
                                                                <li><a class="dropdown-item"
                                                                        href="{{ route('job.edit', ['id' => $savedJob->job_id]) }}"><i
                                                                            class="fa fa-edit" aria-hidden="true"></i>
                                                                        Edit</a></li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('job.unsave', ['id' => $savedJob->id]) }}"
                                                                        class="delete_job" method="post"><button
                                                                            class="dropdown-item btn" type="submit"><i
                                                                                class="fa fa-trash"
                                                                                aria-hidden="true"></i>Unsave</button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>

                                </table>
                            </div>
                            {{ $savedJobs->links() }}
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
        $(".delete_job").on("submit", function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr("action"),
                type: "delete",
                dataType: "json",
                success: function(response) {
                    if (response.status) {
                        window.location.href = "{{ route('jobs.saved') }}";
                    }
                }
            });
        });
    </script>
@endsection
