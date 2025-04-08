@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')
<div class="pagetitle">
    <h1>File Pendukung</h1>    
</div><!-- End Page Title -->
<button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>

<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    
                    <h5 class="card-title">{{$module->title}}</h5>
                    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#modalAdd">
                        Tambah File
                    </button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>File</th>
                                <th>Action</th>
                            </tr>
                        </thead>                        
                        <tbody>                            
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->value}}</td>
                                
                                <td align="right" style="width:1px; white-space:nowrap;">
                                    <!-- Button Form Edit -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal{{$item->id}}">
                                        <span class="bi bi-pencil-square"></span>
                                    </button>                                
                                        
                                </td>
                                <div class="modal fade" id="modal{{$item->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit File</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                          <div class="modal-body">
                                            <form action="{{route('course-module.update', ['module_id' => $item->id])}}" method="POST">
                                                @csrf                                          
                                                @method('PUT')
                                                <div class="row mb-3">
                                                  <label for="inputText" class="col-sm-2 col-form-label">Nama File</label>
                                                  <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" value="{{$item->name}}" required>
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
                <form action="{{route('course-module-detail.add')}}" method="POST" enctype="multipart/form-data">
                    @csrf                                          
                    @method('POST')
                    <input type="hidden" name="module_id" value="{{$module->id}}">
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-2 col-form-label" required>Nama File</label>
                      <div class="col-sm-10">
                        <input type="text" name="name" class="form-control">
                      </div>
                    </div>
                    <div class="row mb-3">
                      <label for="inputText" class="col-sm-2 col-form-label">File PDF</label>
                      <div class="col-sm-10">
                          <input type="file" name="file" class="form-control">
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