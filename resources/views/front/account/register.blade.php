@extends('front.layout.app')
@section('main')
    <section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>
                    <form id="registerForm">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name" aria-describedby="nameError">
                            <small id="nameError"></small>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Enter Email" aria-describedby="emailError">
                            <small id="emailError"></small>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="Enter Password" aria-describedby="passwordError">
                            <small id="passwordError"></small>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="mb-2">Confirm Password*</label>
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Enter Password" aria-describedby="confirmPasswordError">
                            <small id="confirmPasswordError"></small>
                        </div>
                        <button class="btn btn-primary mt-2" type="submit">Register</button>
                    </form>
                </div>
                <div class="mt-4 text-center">
                    <p>Have an account? <a  href="{{ route('account.login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('extra_js')
    <script>
        $("#registerForm").submit(function(e){
            e.preventDefault();
            $.ajax({
            type: "post",
            url: "{{ route('account.process_register') }}",
            data: $(this).serializeArray(),
            dataType: "json",
            success: function (response) {
                    console.log(response);
                    console.log(response.content.password);
                    if (response.status) {
                        $('#name').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        $('#email').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        $('#password').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        $('#confirm_password').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');

                        window.location.href = "{{ route('account.login') }}";
                    } else {
                        if (response.content.name) {
                            $('#name').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.content.name);
                        } else {
                            $('#name').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                        if (response.content.email) {
                            $('#email').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.content.email);
                        } else {
                            $('#email').removeClass('is-invalid').siblings('small').removeClass('invalid-feedback').text('');
                        }
                        if (response.content.password) {
                            $('#password').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.content.password[0]);
                            if (response.content.password[1]) {
                                $('#confirm_password').addClass('is-invalid').siblings('small').addClass('invalid-feedback').text(response.content.password[1]);
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
