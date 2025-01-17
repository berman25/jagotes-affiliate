@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="pagetitle">
    <h1>Course</h1>    
</div><!-- End Page Title -->

<button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">List Kelas</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Cover</th>
                                <th>Deskripsi</th>
                                <th>Info Kelas</th>
                                <th>Action</th>
                            </tr>
                        </thead>                        
                        <tbody>                            
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                <td><img src="{{$item->cover}}" style="max-height:100px;"></td>
                                <td>{!!$item->description!!}</td>
                                <td style="max-height:300px; overflow:auto"> 
                                    <ul class="list-group">
                                        @if (is_array($item->info))
                                            @foreach ($item->info as $row)                                   
                                                <li class="list-group-item">{{$row["subtitle"]}}</li>                        
                                            @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td align="right" style="width:1px; white-space:nowrap;">
                                    <!-- Button Form Edit -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#fullscreenModal{{$item->id}}">
                                        <span class="bi bi-pencil-square"></span>
                                    </button>

                                    <a href="{{route('course-detail', ['course_id' => $item->id])}}" class="btn btn-info"><i class="bi bi-gear"></i></a>
                                    
                                        
                                </td>
                                <div class="modal fade" id="fullscreenModal{{$item->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit Kelas</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('course.update', ['course_id' => $item->id])}}" method="POST">
                                                @csrf                                          
                                                @method('PUT')
                                                <div class="row mb-3">
                                                  <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                                                  <div class="col-sm-10">
                                                    <input type="text" name="title" class="form-control" value="{{$item->title}}">
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Cover Link</label>
                                                    <div class="col-sm-10">
                                                      <input type="text" name="cover" class="form-control" value="{{$item->cover}}">
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label for="inputDescription" class="col-sm-2 col-form-label">Deskripsi</label>
                                                    <div class="col-sm-10">
                                                      <textarea class="form-control" name="description" style="height: 150px">
                                                          {!!$item->description!!}
                                                      </textarea>
                                                    </div>
                                                  </div>
                                                  
                                                <div class="row mb-3">
                                                  <label for="inputBenefit" class="col-sm-2 col-form-label">Info</label>
                                                  <div class="col-sm-10">
                                                    <textarea class="form-control" name="info" style="height: 150px">
                                                        {{json_encode($item->info)}}
                                                    </textarea>
                                                  </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </form>
                                    </div>
                                    </div>
                                    </div>
                                </div><!-- End Full Screen Modal-->
                            
                            </tr>
                        @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
</section>


@stop