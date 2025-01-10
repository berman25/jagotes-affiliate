@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<nav>
    <ol class="breadcrumb">
      {{-- <li class="breadcrumb-item"><a href="{{route('course-view')}}">Course</a></li> --}}
      <li class="breadcrumb-item active">{{$course->title}}</li>
    </ol>
</nav>

<section class="section">
    <div class="row">
        <div class="card mb-3">
            <div class="row g-0">
            <div class="col-md-4">
                <img src="{{$course->cover}}" class="img-fluid rounded-start" alt="...">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                <h5 class="card-title">{{$course->title}}</h5>
                <p class="card-text">{{$course->description}}</p>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>

@stop