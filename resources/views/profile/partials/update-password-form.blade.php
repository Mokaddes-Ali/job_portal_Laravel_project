<form id="changePasswordForm" method="POST" action="{{ route('password.update') }}" class="mt-4">
    @csrf
    @method('PUT')

    <div class="card shadow border-0 mb-4">
        <div class="card-body p-4">
            <h4 class="mb-3">Change Password</h4>

            <!-- Success/Error Message Container -->
            <div id="formStatusMsg" class="text-success small ms-3 pt-1 pb-2">
                @if (session('status') === 'password-updated')
                    ✔️ Password updated successfully.
                @endif
            </div>

            <!-- Old Password -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Old Password*</label>
                <input type="password" class="form-control form-control-sm" id="current_password" name="current_password" placeholder="Enter current password" autocomplete="current-password">
                <div class="text-danger small mt-1">
                    @if ($errors->updatePassword->has('current_password'))
                        {{ $errors->updatePassword->first('current_password') }}
                    @endif
                </div>
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password*</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter new password" autocomplete="new-password">
                <div class="text-danger small mt-1">
                    @if ($errors->updatePassword->has('password'))
                        {{ $errors->updatePassword->first('password') }}
                    @endif
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password*</label>
                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password">
                <div class="text-danger small mt-1">
                    @if ($errors->updatePassword->has('password_confirmation'))
                        {{ $errors->updatePassword->first('password_confirmation') }}
                    @endif
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="card-footer bg-white d-flex justify-content-between align-items-center px-4 py-3">
            <button type="submit" class="btn btn-sm btn-primary">Update Password</button>
        </div>
    </div>
</form>

@section('customjs')
<script>
    $(document).ready(function() {
        const $passwordForm = $('#changePasswordForm');
        const $passwordSubmitBtn = $passwordForm.find('button[type="submit"]');
        const defaultPasswordBtnText = $passwordSubmitBtn.html();

        $passwordForm.on('submit', function(e) {
            e.preventDefault();

            $('#formStatusMsg').removeClass().text('');
            $('.text-danger.small.mt-1').text('');
            $passwordSubmitBtn.prop('disabled', true).html('🔄 Updating...');

            $.ajax({
                url: $passwordForm.attr('action'),
                method: 'POST',
                data: $passwordForm.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val()
                },
                success: function(response) {
                    $passwordSubmitBtn.prop('disabled', false).html(defaultPasswordBtnText);

                    $('#formStatusMsg')
                        .removeClass()
                        .addClass('text-success small ms-3 pt-1 pb-2')
                        .html('✔️ Password updated successfully.');

                    $passwordForm[0].reset();
                },
                error: function(xhr) {
                    $passwordSubmitBtn.prop('disabled', false).html(defaultPasswordBtnText);
                    $('.text-danger.small.mt-1').text('');

                    if (xhr.status === 422) {
                        const errors = xhr.responseJSON.errors;

                        if (errors.current_password) {
                            $('#current_password').next('.text-danger').text(errors.current_password[0]);
                        }
                        if (errors.password) {
                            $('#password').next('.text-danger').text(errors.password[0]);
                        }
                        if (errors.password_confirmation) {
                            $('#password_confirmation').next('.text-danger').text(errors.password_confirmation[0]);
                        }
                    } else {
                        $('#formStatusMsg')
                            .removeClass()
                            .addClass('text-danger small ms-3 pt-1 pb-2')
                            .html('❌ Something went wrong. Please try again.');
                    }
                }
            });
        });
    });
</script>

@endsection
