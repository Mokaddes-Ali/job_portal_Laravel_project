@extends('fontend.layout.user-dashboard')

@section('dashboard')

@include('profile.partials.update-profile-information-form', ['user' => $user])

@include('profile.partials.update-password-form', ['user' => $user])
@include('profile.partials.delete-user-form', ['user' => $user])

 @endsection
