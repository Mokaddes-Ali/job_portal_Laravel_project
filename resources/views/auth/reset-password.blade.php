@extends('fontend.layout.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h4 mb-3">Reset Password</h1>

                    <!-- AJAX Message -->
                    <div id="resetMessage" class="mb-2"></div>

                    <!-- Reset Form -->
                    <form method="POST" action="{{ route('password.store') }}" id="resetForm">
                        @csrf

                        <!-- Token -->
                        <input type="hidden" name="token" value="{{ $request->route('token') }}">

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="mb-2 small">Email Address*</label>
                            <input type="email" id="email" name="email" class="form-control form-control-sm"
                                   value="{{ old('email', $request->email) }}" required autofocus>
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="mb-2 small">New Password*</label>
                            <input type="password" id="password" name="password" class="form-control form-control-sm"
                                   required autocomplete="new-password">
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="mb-2 small">Confirm Password*</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control form-control-sm" required autocomplete="new-password">
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <a href="{{ route('login') }}" class="small">← Back to Login</a>
                            <button type="submit" class="btn btn-sm btn-primary" id="resetBtn">Reset Password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customjs')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        const $form = $('#resetForm');
        const $btn = $('#resetBtn');
        const defaultBtnText = $btn.html();

        $form.on('submit', function (e) {
            e.preventDefault();
            $('#resetMessage').html('');
            $btn.prop('disabled', true).html('🔄 Resetting...');

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: $form.serialize(),
                success: function (response) {
                    $('#resetMessage').html('<div class="alert alert-success small">✔️ Password reset successfully. You may now log in.</div>');
                    $btn.prop('disabled', false).html(defaultBtnText);
                    $form[0].reset();
                },
                error: function (xhr) {
                    $btn.prop('disabled', false).html(defaultBtnText);

                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let html = '<div class="alert alert-danger small"><ul>';
                        $.each(errors, function (key, value) {
                            html += '<li>' + value[0] + '</li>';
                        });
                        html += '</ul></div>';
                        $('#resetMessage').html(html);
                    } else {
                        $('#resetMessage').html('<div class="alert alert-danger small">❌ Something went wrong. Please try again.</div>');
                    }
                }
            });
        });
    });
</script>
@endsection

