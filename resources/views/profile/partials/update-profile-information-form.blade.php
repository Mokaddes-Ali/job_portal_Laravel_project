               <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div class="card border-0 shadow mb-4">
        <div class="card-body p-4">
            <h4 class="mb-3">My Profile</h4>

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" name="name" id="name" class="form-control form-control-sm" placeholder="Enter Name"
                       value="{{ old('name', auth()->user()->name) }}" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email*</label>
                <input type="email" name="email" id="email" class="form-control form-control-sm" placeholder="Enter Email"
                       value="{{ old('email', auth()->user()->email) }}" required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                    <div class="text-warning small mt-2">
                        Your email address is unverified. 
                        <button form="send-verification" type="submit" class="btn btn-link p-0 align-baseline">Click here to re-send</button>
                        @if (session('status') === 'verification-link-sent')
                            <div class="text-success small mt-1">✔️ Verification link sent.</div>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Designation (Optional Field) -->
            <!-- <div class="mb-3">
                <label for="designation" class="form-label">Designation</label>
                <input type="text" name="designation" id="designation" class="form-control form-control-sm" placeholder="Enter designation"
                       value="{{ old('designation', $user->designation ?? '') }}">
                @error('designation')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->

            <!-- Mobile (Optional Field) -->
            <!-- <div class="mb-3">
                <label for="mobile" class="form-label">Mobile</label>
                <input type="text" name="mobile" id="mobile" class="form-control form-control-sm" placeholder="Enter mobile number"
                       value="{{ old('mobile', $user->mobile ?? '') }}">
                @error('mobile')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div> -->
        </div>

        <!-- Submit -->
        <div class="card-footer bg-white border-top-0 p-3 d-flex justify-content-between align-items-center">
            <button type="submit" class="btn btn-sm btn-primary">Update</button>

            @if (session('status') === 'profile-updated')
                <span class="text-success small">✔️ Profile updated.</span>
            @endif
        </div>
    </div>
</form>

<!-- Hidden form for verification resend -->
<form id="send-verification" method="POST" action="{{ route('verification.send') }}" class="d-none">
    @csrf
</form>