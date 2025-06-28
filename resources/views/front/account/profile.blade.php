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
                @include('front.component.message')
                <form id="userProfileForm" method="post">
                    @csrf
                    @method('put')
                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">My Profile</h3>
                            <div class="mb-4">
                                <label for="name" class="mb-2">Name*</label>
                                <input type="text" name="name" id="name" placeholder="Enter Name" class="form-control" value="{{ $user->name }}">
                                <small></small>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="text" name="email" id="email" placeholder="Enter Email" class="form-control" value="{{ $user->email }}">
                                <small></small>
                            </div>
                            <div class="mb-4">
                                <label for="designation" class="mb-2">Designation*</label>
                                <input type="text" name="designation" id="designation" placeholder="Designation" class="form-control" value="{{ $user->designation }}">
                            </div>
                            <div class="mb-4">
                                <label for="mobile" class="mb-2">Mobile*</label>
                                <input type="text" name="mobile" id="mobile" placeholder="Mobile" class="form-control" value="{{ $user->mobile }}">
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
                        </div>
                    </div>

                    <div class="card border-0 shadow mb-4">
                        <div class="card-body p-4">
                            <h3 class="fs-4 mb-1">Change Password</h3>
                            <div class="mb-4">
                                <label for="old_password" class="mb-2">Old Password*</label>
                                <input type="password" name="old_password" id="old_password" placeholder="Old Password" class="form-control">
                                <small></small>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="mb-2">New Password*</label>
                                <input type="password" name="password" id="password" placeholder="New Password" class="form-control">
                                <small></small>
                            </div>
                            <div class="mb-4">
                                <label for="confirm_password" class="mb-2">Confirm Password*</label>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" class="form-control">
                                <small></small>
                            </div>
                        </div>
                        <div class="card-footer  p-4">
                            <button type="submit" class="btn btn-primary">Update</button>
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
    </script>
@endsection
