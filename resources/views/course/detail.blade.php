@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="pagetitle">
    <h1>Course Module</h1>    
</div><!-- End Page Title -->
<button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>

<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    
                    <h5 class="card-title">{{$course->title}}</h5>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
                        Tambah Module
                    </button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Info</th>
                                <th>Jadwal</th>
                                {{-- <th>Detail</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>                        
                        <tbody>                            
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->title}}</td>
                                <td>{{$item->schedule_detail}}</td>
                                <td>{{$item->schedule}}</td>
                                {{-- <td style="max-width:200px; overflow:auto"> 
                                    <ul class="list-group">
                                        @if (is_array($item->detail))
                                            @foreach ($item->detail as $key => $value)                                            
                                                @if ($key == "record")
                                                    <a href="{{$value}}" target="_blank">
                                                        <li class="list-group-item">
                                                            <i class="bi bi-youtube text-success"></i>                                                        
                                                        </li> 
                                                    </a>
                                                @elseif ($key == "link_zoom")
                                                    <a href="{{$value}}" target="_blank">
                                                        <li class="list-group-item">
                                                            <i class="bi bi-camera-video text-success"></i>                                                        
                                                        </li> 
                                                    </a>
                                                @elseif ($key == "file")
                                                    <a href="{{$value}}" target="_blank">
                                                        <li class="list-group-item">
                                                            <i class="bi bi-file-earmark-pdf text-success"></i>                                                        
                                                        </li> 
                                                    </a>
                                                @endif                                
                                                                      
                                            @endforeach
                                        @endif
                                    </ul>
                                </td> --}}
                                
                                <td align="right" style="width:1px; white-space:nowrap;">
                                    <!-- Button Form Edit -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal{{$item->id}}">
                                        <span class="bi bi-pencil-square"></span>
                                    </button>
                                    <a href="{{route('course-quiz.view', ['module_id' => $item->id])}}" type="button" class="btn btn-success">
                                      <span class="bi bi-book"></span>
                                    </a>
                                  <a type="button" class="btn btn-primary">
                                    <span class="bi bi-file-earmark-word"></span>
                                  </a>
                                        
                                </td>
                                <div class="modal fade" id="modal{{$item->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit Modul</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                          <div class="modal-body">
                                            <form action="{{route('course-module.update', ['module_id' => $item->id])}}" method="POST">
                                                @csrf                                          
                                                @method('PUT')
                                                <div class="row mb-3">
                                                  <label for="inputText" class="col-sm-2 col-form-label">Judul</label>
                                                  <div class="col-sm-10">
                                                    <input type="text" name="title" class="form-control" value="{{$item->title}}" required>
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Caption</label>
                                                    <div class="col-sm-10">
                                                      <input type="text" name="schedule_detail" class="form-control" value="{{$item->schedule_detail}}">
                                                    </div>
                                                  </div>
                                                
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Jadwal</label>
                                                    <div class="col-sm-10">
                                                      <input type="date" name="schedule" class="form-control" value="{{$item->schedule}}">
                                                    </div>
                                                  </div>

                                                  <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Link Zoom</label>
                                                    <div class="col-sm-10">
                                                      <input type="text" name="link_zoom" class="form-control" value="{{$item->detail["link_zoom"] ?? null}}">
                                                    </div>
                                                  </div> 

                                                  <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Link Youtube</label>
                                                    <div class="col-sm-10">
                                                      <input type="text" name="record" class="form-control" value="{{$item->detail["record"] ?? null}}">
                                                    </div>
                                                  </div>
                                                  

                                                
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Save changes</button>
                                            </form>
                                          </div>
                                      </div>
                                    </div>
                                </div>
                            
                            </tr>
                        @endforeach
                        </tbody>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title">Tambah Modul</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
              <div class="modal-body">
                <form action="{{route('course-module.create')}}" method="POST">
                    @csrf                                          
                    @method('POST')
                    <input type="hidden" name="course_id" value="{{$course->id}}">
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-2 col-form-label" required>Judul</label>
                      <div class="col-sm-10">
                        <input type="text" name="title" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Caption</label>
                        <div class="col-sm-10">
                          <input type="text" name="schedule_detail" class="form-control">
                        </div>
                      </div>
                    
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Jadwal</label>
                        <div class="col-sm-10">
                          <input type="date" name="schedule" class="form-control">
                        </div>
                      </div>
                      <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Link Zoom</label>
                        <div class="col-sm-10">
                          <input type="text" name="link_zoom" class="form-control">
                        </div>
                      </div> 
                      <div class="row mb-3">
                        <label for="inputText" class="col-sm-2 col-form-label">Link Youtube</label>
                        <div class="col-sm-10">
                          <input type="text" name="record" class="form-control">
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
    </div>
</section>

@stop