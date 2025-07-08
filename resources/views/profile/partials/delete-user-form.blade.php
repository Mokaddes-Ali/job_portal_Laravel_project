<!-- Delete Account Card -->
<div class="card border-0 shadow mb-4">
    <div class="card-body p-4">
        <h4 class="mb-3">Delete Account</h4>
        <p class="small text-muted">
            Once your account is deleted, all of its resources and data will be permanently deleted. Please download any data or information that you wish to retain.
        </p>

        <!-- Delete Button -->
        <button class="btn btn-sm btn-danger mt-2" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Delete Account
        </button>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('profile.destroy') }}">
            @csrf
            @method('DELETE')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Account Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <p class="small text-muted">
                        Are you sure you want to delete your account? All data will be lost permanently. Please enter your password to confirm:
                    </p>

                    <!-- Password Input -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password*</label>
                        <input type="password" name="password" id="password" class="form-control form-control-sm" placeholder="Enter your password" required>
                        @error('password', 'userDeletion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-sm btn-danger">Delete Account</button>
                </div>
            </div>
        </form>
    </div>
</div>
