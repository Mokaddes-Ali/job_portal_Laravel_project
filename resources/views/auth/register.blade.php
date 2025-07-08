@extends('fontend.layout.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h3">Register</h1>

                    <!-- AJAX Success/Error Alert -->
                    <div id="formMessage"></div>

                    <form method="POST" action="{{ route('register') }}" id="registrationForm">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="mb-2">Name*</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="mb-2">Email*</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="mb-2">Password*</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="mb-2">Confirm Password*</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                        </div>

                        <!-- Captcha Image -->
                        <div class="mb-3">
                            <label for="captcha">Captcha*</label><br>
                            <span id="captcha-img">{!! captcha_img() !!}</span>
                            <button type="button" class="btn btn-sm btn-secondary" id="reloadCaptcha">⟳</button>
                        </div>

                        <!-- Captcha Input -->
                        <div class="mb-3">
                            <input type="text" name="captcha" class="form-control" placeholder="Enter Captcha" required>
                        </div>


                        <!-- Submit -->
                        <button type="submit" class="btn btn-primary mt-2">Register</button>
                    </form>
                </div>

                <!-- Login Link -->
                <div class="mt-4 text-center">
                    <p>Have an account? <a href="{{ route('login') }}">Login</a></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ✅ jQuery Ajax Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {

        // ✅ Captcha Reload
        $('#reloadCaptcha').click(function () {
            $.ajax({
                type: 'GET',
                url: '{{ url("reload-captcha") }}',
                success: function (data) {
                    $('#captcha-img').html(data.captcha);
                }
            });
        });

        // ✅ Registration Form Submit with AJAX
        $('#registrationForm').submit(function (e) {
            e.preventDefault();
            $('#formMessage').html(''); // clear old message

            $.ajax({
                url: '{{ route("register") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#formMessage').html('<div class="alert alert-success">Registration successful! Redirecting...</div>');
                    $('#registrationForm')[0].reset();
                    $('#reloadCaptcha').click(); // captcha reload

                    // Optional: Redirect after few seconds
                    setTimeout(() => {
                        window.location.href = '{{ route("dashboard") }}';
                    }, 2000);
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<div class="alert alert-danger"><ul>';
                    $.each(errors, function (key, value) {
                        errorHtml += '<li>' + value[0] + '</li>';
                    });
                    errorHtml += '</ul></div>';
                    $('#formMessage').html(errorHtml);

                    $('#reloadCaptcha').click(); // captcha reload on error
                }
            });
        });
    });
</script>

@endsection