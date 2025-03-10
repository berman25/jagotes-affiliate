@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('content')

<div class="pagetitle d-flex">
    <h1>Tryout</h1>    
</div><!-- End Page Title -->

<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">List Tryout</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Cover</th>
                                <th>Deskripsi</th>
                                <th>Sidebar Info</th>
                                <th>Action</th>
                            </tr>
                        </thead>                        
                        <tbody>                            
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td><img src="{{$item->cover}}" style="max-height:100px;"></td>
                                <td>{!!$item->description!!}</td>
                                <td style="max-height:300px; overflow:auto"> 
                                    <ul class="list-group">
                                        @if (is_array($item->sidebar_info))
                                            @foreach ($item->sidebar_info as $row)                                   
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

                                    <a href="{{route('tryout-participant', ['package_id' => $item->id])}}" class="btn btn-info"><i class="bi bi-people-fill"></i></a>
                                    
                                        
                                </td>
                                <div class="modal fade" id="fullscreenModal{{$item->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit Tryout</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('tryout.update', ['package_id' => $item->id])}}" method="POST" enctype="multipart/form-data">
                                                @csrf                                          
                                                @method('PUT')
                                                <div class="row mb-3">
                                                  <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                                                  <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" value="{{$item->name}}">
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Cover Link</label>
                                                    <div class="col-sm-10">
                                                        <input type="file" name="cover" class="form-control">
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label for="inputDescription" class="col-sm-2 col-form-label">Deskripsi</label>
                                                    <div class="col-sm-10">
                                                      <textarea class="form-control" name="description" id="txtEditor1">
                                                          {!!$item->description!!}
                                                      </textarea>
                                                    </div>
                                                  </div>
                                                  
                                                <div class="row mb-3">
                                                  <label for="inputBenefit" class="col-sm-2 col-form-label">Sidebar Info</label>
                                                  <div class="col-sm-10">
                                                    <input class="form-control" name="subtitle" value="{{$item->sidebar_info[0]["subtitle"]??null}}">                                                        
                                                  </div>                                                  
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputBenefit" class="col-sm-2 col-form-label">Button Text</label>
                                                    <div class="col-sm-5">
                                                      <input class="form-control" name="button_text" value="{{$item->sidebar_info[0]["button"]["text"]??null}}">                                                        
                                                    </div>                                                  
                                                </div>
                                                <div class="row mb-3">
                                                    <label for="inputBenefit" class="col-sm-2 col-form-label">Button Link</label>
                                                    <div class="col-sm-10">
                                                      <input class="form-control" name="button_link" value="{{$item->sidebar_info[0]["button"]["link"]??null}}">                                                        
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

@section('js')
<script src="https://cdn.ckeditor.com/ckeditor5/41.2.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
		.create( document.querySelector( '#txtEditor1' ) )
        .then( newEditor => {
            editor1 = newEditor;
        } )
		.catch( error => {
			console.error( error );
		} );
</script>
@stop