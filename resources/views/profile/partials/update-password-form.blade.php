      <form id="changePasswordForm" method="POST" action="{{ route('password.update') }}" class="mt-4">
    @csrf
    @method('PUT')

    <div class="card shadow border-0 mb-4">
        <div class="card-body p-4">
            <h4 class="mb-3">Change Password</h4>
              @if (session('status') === 'password-updated')
                <div class="text-success small ms-3 pt-1 pb-2">✔️ Password updated successfully.</div>
            @endif

            <!-- Old Password -->
            <div class="mb-3">
                <label for="current_password" class="form-label">Old Password*</label>
                <input type="password" class="form-control form-control-sm" id="current_password" name="current_password" placeholder="Enter current password" autocomplete="current-password">
                @if ($errors->updatePassword->has('current_password'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                @endif
            </div>

            <!-- New Password -->
            <div class="mb-3">
                <label for="password" class="form-label">New Password*</label>
                <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Enter new password" autocomplete="new-password">
                @if ($errors->updatePassword->has('password'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
                @endif
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password*</label>
                <input type="password" class="form-control form-control-sm" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password" autocomplete="new-password">
                @if ($errors->updatePassword->has('password_confirmation'))
                    <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                @endif
            </div>
        </div>

        <!-- Submit Button and Success Message -->
        <div class="card-footer bg-white d-flex justify-content-between align-items-center px-4 py-3">
            <button type="submit" class="btn btn-sm btn-primary">Update Password</button>

        </div>
    </div>
</form>


<script>
document.getElementById('changePasswordForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = this;
    const formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'password-updated') {
            alert('✔️ Password updated successfully.');
            form.reset();
        } else if (data.errors) {
            // Error দেখাতে চাইলে এখানেও handle করতে পারেন
            console.error(data.errors);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
});
</script>
