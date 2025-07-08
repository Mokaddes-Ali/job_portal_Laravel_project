@extends('fontend.layout.app')

@section('main')

    <!-- Session Status -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <section class="section-5">
        <div class="container my-5">
            <div class="py-lg-2">&nbsp;</div>
            <div class="row d-flex justify-content-center">
                <div class="col-md-5">
                    <div class="card shadow border-0 p-5">
                        <h1 class="h3">Login</h1>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label for="email" class="mb-2">Email*</label>
                                <input type="email" name="email" id="email"
                                       value="{{ old('email') }}"
                                       required autofocus autocomplete="username"
                                       class="form-control">
                                @error('email')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="mb-2">Password*</label>
                                <input type="password" name="password" id="password"
                                       required autocomplete="current-password"
                                       class="form-control">
                                @error('password')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <button type="submit" class="btn btn-primary mt-2">Login</button>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="mt-3">Forgot Password?</a>
                                @endif
                            </div>
                        </form>
                    </div>

                    <!-- Register Link -->
                    <div class="mt-4 text-center">
                        <p>Do not have an account?
                            <a href="{{ route('register') }}">Register</a>
                        </p>
                    </div>
                </div>
            </div>
            <div class="py-lg-5">&nbsp;</div>
        </div>
    </section>

@endsection

