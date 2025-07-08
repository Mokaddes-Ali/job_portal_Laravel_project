@extends('fontend.layout.app')

@section('main')

@include('fontend/pages/home/hero')
@include('fontend/pages/home/searchbox')
@include('fontend/pages/home/popularcategory')
@include('fontend/pages/home/featuredjob')
@include('fontend/pages/home/latestjob')

@endsection