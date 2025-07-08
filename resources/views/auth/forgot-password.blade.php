@extends('fontend.layout.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h4 mb-3">Forgot Password</h1>

                    <!-- Success / Error Message -->
                    <div id="formMessage" class="text-sm mb-3 text-muted"></div>

                    <form method="POST" action="{{ route('password.email') }}" id="forgotPasswordForm">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="mb-2 small">Email Address*</label>
                            <input type="email" name="email" id="email" class="form-control form-control-sm" required autofocus>
                        </div>
                         <div class="d-flex justify-content-between align-items-center mt-3">
                          <a href="{{ route('login') }}" class="small">← Back to Login</a>
                        <button type="submit" class="btn btn-sm btn-primary mt-2">Reset Link</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        $('#forgotPasswordForm').submit(function (e) {
            e.preventDefault();
            $('#formMessage').html('');

            $.ajax({
                url: '{{ route("password.email") }}',
                method: 'POST',
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function (response) {
                    $('#formMessage').html('<div class="alert alert-success small">Reset link sent successfully! Please check your email.</div>');
                    $('#forgotPasswordForm')[0].reset();
                },
                error: function (xhr) {
                    let msg = 'Something went wrong.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        msg = Object.values(xhr.responseJSON.errors)[0][0];
                    } else if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    $('#formMessage').html('<div class="alert alert-danger small">' + msg + '</div>');
                }
            });
        });
    });
</script>
@endsection
