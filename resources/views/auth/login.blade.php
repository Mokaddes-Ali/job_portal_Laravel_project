@extends('fontend.layout.app')

@section('main')

<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Login</h1>

                    <!-- Login Status -->
                    <div id="loginStatusMsg" class="text-success small mb-2"></div>

                    <form id="loginForm" method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="username" class="form-control">
                            <div class="text-danger small mt-1" id="emailError"></div>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password"
                                   required autocomplete="current-password" class="form-control">
                            <div class="text-danger small mt-1" id="passwordError"></div>
                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn btn-primary mt-2" id="loginBtn">Login</button>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="mt-3">Forgot Password?</a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Register Link -->
                <div class="mt-4 text-center">
                    <p>Do not have an account?
                        <a href="#" data-route="{{ route('register') }}">Register</a>
                    </p>
                </div>
            </div>
        </div>
        <div class="py-lg-5">&nbsp;</div>
    </div>
</section>

@endsection

@section('customjs')
<script>
$(document).ready(function() {
    const $form = $('#loginForm');
    const $btn = $('#loginBtn');
    const defaultText = $btn.html();

    $form.on('submit', function(e) {
        e.preventDefault();

        $('#loginStatusMsg').text('');
        $('#emailError').text('');
        $('#passwordError').text('');
        $btn.prop('disabled', true).html('Logging in...');

        $.ajax({
            url: $form.attr('action'),
            method: 'POST',
            data: $form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('input[name="_token"]').val()
            },
            success: function(response) {
                $btn.prop('disabled', false).html(defaultText);

                // Optional: redirect on success
                if (response.redirect) {
                    window.location.href = response.redirect;
                } else {
                    $('#loginStatusMsg').text('Login successful!');
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html(defaultText);

                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.email) {
                        $('#emailError').text(errors.email[0]);
                    }
                    if (errors.password) {
                        $('#passwordError').text(errors.password[0]);
                    }
                } else if (xhr.status === 401) {
                    $('#loginStatusMsg').removeClass().addClass('text-danger small mb-2').text('Invalid credentials.');
                } else {
                    $('#loginStatusMsg').removeClass().addClass('text-danger small mb-2').text('Something went wrong.');
                }
            }
        });
    });
});
</script>
@endsection
