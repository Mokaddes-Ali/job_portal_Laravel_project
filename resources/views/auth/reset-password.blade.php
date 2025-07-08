@extends('fontend.layout.app')

@section('main')
<section class="section-5">
    <div class="container my-5">
        <div class="py-lg-2">&nbsp;</div>
        <div class="row d-flex justify-content-center">
            <div class="col-md-5">
                <div class="card shadow border-0 p-5">
                    <h1 class="h4 mb-3">Reset Password</h1>

                    <!-- Success/Error Message -->
                    @if(session('status'))
                        <div class="alert alert-success small">{{ session('status') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger small">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li class="small">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Reset Form -->
                    <form method="POST" action="{{ route('password.store') }}">
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
    <button type="submit" class="btn btn-sm btn-primary">Reset Password</button>
</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
