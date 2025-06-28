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
                <form id="userProfileForm" method="post"></form>
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
