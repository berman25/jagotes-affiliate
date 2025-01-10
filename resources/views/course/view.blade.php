@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="pagetitle">
    <h1>Course</h1>    
</div><!-- End Page Title -->

<a href="#" onclick="history.back()">kembali</a>
@foreach ($data as $item)
    <section class="section">
        <a href="{{route('course-detail', ['course_id' => $item->id])}}">
            <div class="row">
                <div class="card mb-3">
                    <div class="row g-0">
                    <div class="col-md-3">
                        <img src="{{$item->cover}}" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                        <h5 class="card-title">{{$item->title}}</h5>
                        <p class="card-text">{{$item->description}}</p>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </a>
    </section>    
@endforeach


@stop