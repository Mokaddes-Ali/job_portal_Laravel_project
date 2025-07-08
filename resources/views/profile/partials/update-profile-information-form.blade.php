<form id="profileUpdateForm" method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="card border-0 shadow mb-4">
        <div class="card-body p-4">
            <h4 class="mb-3">My Profile</h4>

            <!-- Success Message -->
            <div id="profileStatusMsg" class="text-success small mb-3">
                @if (session('status') === 'profile-updated')
                    ✔️ Profile updated.
                @endif
            </div>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Name"
                       value="{{ old('name', $user->name) }}" required>
                <div class="text-danger small mt-1"></div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Enter Email"
                       value="{{ old('email', $user->email) }}" required>
                <div class="text-danger small mt-1"></div>

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div class="text-warning small mt-2">
                        Your email address is unverified. 
                        <button form="send-verification" type="submit" class="btn btn-link p-0 align-baseline">Click here to re-send</button>
                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success small mt-1">✔️ Verification link sent.</div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Designation -->
            <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" name="designation" id="designation" class="form-control form-control-sm" placeholder="Enter designation"
                       value="{{ old('designation', $user->designation ?? '') }}">
                <div class="text-danger small mt-1"></div>
            </div>

            <!-- Mobile -->
            <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" placeholder="Enter mobile number"
                       value="{{ old('mobile', $user->mobile ?? '') }}">
                <div class="text-danger small mt-1"></div>
            </div>
        </div>

        <!-- Submit -->
        <div class="card-footer bg-white border-top-0 p-3 d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-sm btn-primary">Update</button>
        </div>
    </div>
</form>

<!-- Hidden form for verification resend -->
<form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="d-none">
    @csrf
</form>

@section('customjs')
<script>
$(document).ready(function() {

    // ✅ Profile Form Submit
    const $profileForm = $('#profileUpdateForm');
    const $profileBtn = $profileForm.find('button[type="submit"]');
    const defaultProfileText = $profileBtn.html();

    $profileForm.on('submit', function(e) {
        e.preventDefault();
        $('#profileStatusMsg').removeClass().text('');
        $profileBtn.prop('disabled', true).html('🔄 Updating...');
        $('.text-danger.small.mt-1').text('');

        $.ajax({
            url: $profileForm.attr('action'),
            method: 'POST',
            data: $profileForm.serialize(),
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            success: function(response) {
                $profileBtn.prop('disabled', false).html(defaultProfileText);
                $('#profileStatusMsg').removeClass().addClass('text-success small mb-3').html('✔️ Profile updated successfully.');
            },
            error: function(xhr) {
                $profileBtn.prop('disabled', false).html(defaultProfileText);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.name) $('#name').next('.text-danger').text(errors.name[0]);
                    if (errors.email) $('#email').next('.text-danger').text(errors.email[0]);
                    if (errors.designation) $('#designation').next('.text-danger').text(errors.designation[0]);
                    if (errors.mobile) $('#mobile').next('.text-danger').text(errors.mobile[0]);
                } else {
                    $('#profileStatusMsg').removeClass().addClass('text-danger small mb-3').html('❌ Something went wrong.');
                }
            }
        });
    });


    // ✅ Password Form Submit
    const $passwordForm = $('#changePasswordForm');
    const $passwordBtn = $passwordForm.find('button[type="submit"]');
    const defaultPasswordText = $passwordBtn.html();

    $passwordForm.on('submit', function(e) {
        e.preventDefault();
        $('#formStatusMsg').removeClass().text('');
        $passwordBtn.prop('disabled', true).html('🔄 Updating...');
        $('.text-danger.small.mt-1').text('');

        $.ajax({
            url: $passwordForm.attr('action'),
            method: 'POST',
            data: $passwordForm.serialize(),
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val() },
            success: function(response) {
                $passwordBtn.prop('disabled', false).html(defaultPasswordText);
                $('#formStatusMsg').removeClass().addClass('text-success small').html('✔️ Password updated successfully.');
                $passwordForm[0].reset();
            },
            error: function(xhr) {
                $passwordBtn.prop('disabled', false).html(defaultPasswordText);
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    if (errors.current_password) $('#current_password').next('.text-danger').text(errors.current_password[0]);
                    if (errors.password) $('#password').next('.text-danger').text(errors.password[0]);
                    if (errors.password_confirmation) $('#password_confirmation').next('.text-danger').text(errors.password_confirmation[0]);
                } else {
                    $('#formStatusMsg').removeClass().addClass('text-danger small').html('❌ Something went wrong.');
                }
            }
        });
    });

});
</script>
@endsection
