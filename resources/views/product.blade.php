@extends('layouts.app')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">List Produk</h5>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Benefit</th>
                                <th>Harga Coret</th>
                                <th>Harga Jual</th>
                                <th>Jenis Produk</th>
                                <th>Action</th>
                            </tr>
                        </thead>                        
                        <tbody>                            
                        @foreach ($collection as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td style="max-height:300px; overflow:auto"> 
                                    <ul class="list-group">
                                        @if (is_array($item->benefits))
                                            @foreach ($item->benefits as $row)                                   
                                                <li class="list-group-item">{{$row["label"]}}</li>                        
                                            @endforeach
                                        @endif
                                    </ul>
                                </td>
                                <td>{{$item->price}}</td>
                                <td>{{$item->sale_price}}</td>
                                <td>{{$item->product_type}}</td>
                                <td align="right" style="width:1px; white-space:nowrap;">
                                    <!-- Button Form Edit -->
                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#fullscreenModal{{$item->id}}">
                                        <span class="bi bi-pencil-square"></span>
                                    </button>
                                        
                                </td>
                                <div class="modal fade" id="fullscreenModal{{$item->id}}" tabindex="-1">
                                    <div class="modal-dialog modal-fullscreen">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit Produk</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('product.update', ['product_id' => $item->id])}}" method="POST">
                                                @csrf                                          
                                                @method('PUT')
                                                <div class="row mb-3">
                                                  <label for="inputText" class="col-sm-2 col-form-label">Nama</label>
                                                  <div class="col-sm-10">
                                                    <input type="text" name="name" class="form-control" value="{{$item->name}}">
                                                  </div>
                                                </div>
                                                <div class="row mb-3">
                                                  <label for="inputBenefit" class="col-sm-2 col-form-label">Benefit</label>
                                                  <div class="col-sm-10">
                                                    <textarea class="form-control" name="benefits" style="height: 150px">
                                                        {{json_encode($item->benefits)}}
                                                    </textarea>
                                                  </div>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Harga Coret</label>
                                                    <div class="col-sm-10">
                                                      <input type="number" name="price" class="form-control" value="{{$item->price}}">
                                                    </div>
                                                  </div>
                                                  <div class="row mb-3">
                                                    <label for="inputText" class="col-sm-2 col-form-label">Harga Jual</label>
                                                    <div class="col-sm-10">
                                                      <input type="number" name="sale_price" class="form-control" value="{{$item->sale_price}}">
                                                    </div>
                                                  </div>
                                                <div class="row mb-3">
                                                  <label class="col-sm-2 col-form-label">Pilih</label>
                                                  <div class="col-sm-10">
                                                    <select class="form-select" name="product_type" aria-label="Default select example">
                                                      <option value="kelas">Kelas</option>
                                                      <option value="tryout">Tryout</option>
                                                    </select>
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
@endsection
