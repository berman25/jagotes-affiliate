@extends('layouts.app')

@section('content')
<section class="section contact">
    <button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>
    <div class="row">
        <div class="col-lg-12">
            <div class="info-box card">
                <h3>Dashboard Banner</h3>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Free TO / Simulasi Banner</td>
                                <td>Free Webinar Banner</td>
                            </tr>
                            <tr>
                                <td>ID = {{$banner->simulasi_id}}</td>
                                <td>ID = {{$banner->module_id}}</td>
                            </tr>
                            <tr>
                                <td><img src="{{$banner->free_tryout}}" style="max-height:150px;"></td>
                                <td><img src="{{$banner->free_webinar}}" style="max-height:150px;"></td>
                            </tr>
                        </tbody>

                    </table>
                    
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-dashboard-banner">
                        <span class="bi bi-pencil-square"></span>
                    </button>
                    <div class="modal fade" id="modal-dashboard-banner" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Dashboard Banner</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('site.update-dashboard-banner', ['site_id' => $site->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf                                          
                                    @method('PUT')                                   
                                                                        
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Banner Simulasi</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="free_tryout" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">ID Simulasi / TO</label>
                                        <div class="col-sm-10">
                                          <input type="text" name="simulasi_id" class="form-control" value="{{$banner->simulasi_id}}">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Banner webinar</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="free_webinar" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">ID Webinar</label>
                                        <div class="col-sm-10">
                                          <input type="text" name="module_id" class="form-control" value="{{$banner->module_id}}">
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
                </div>      
            </div>
        </div>

        <div class="col-lg-12">
            <div class="info-box card">
                <div class="card-body">
                    <h3 class="card-title">Login Banner</h3>    
                  
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @if ($banner->login_banner_1)
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            @endif

                            @if ($banner->login_banner_2)
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                            @endif

                            @if ($banner->login_banner_3)
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            @endif                      
                        </div>
                        <div class="carousel-inner">
                            @if ($banner->login_banner_1)
                                <div class="carousel-item active">
                                    <img src="{{$banner->login_banner_1}}" class="d-block w-100" alt="...">
                                </div>
                            @endif
                            @if ($banner->login_banner_2)
                                <div class="carousel-item">
                                    <img src="{{$banner->login_banner_2}}" class="d-block w-100" alt="...">
                                </div>
                            @endif
                            @if ($banner->login_banner_3)
                                <div class="carousel-item">
                                    <img src="{{$banner->login_banner_3}}" class="d-block w-100" alt="...">
                                </div>
                            @endif
                        </div>
        
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>        
                    </div>
    
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-login-banner">
                        <span class="bi bi-pencil-square"></span>
                    </button>

                    <div class="modal fade" id="modal-login-banner" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Login Banner</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('site.update-login-banner', ['site_id' => $site->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf                                          
                                    @method('PUT')                                   
                                                                        
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Banner 1</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="login_banner_1" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Banner 2</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="login_banner_2" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Banner 3</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="login_banner_3" class="form-control">
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
                
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="info-box card">
                <h3>Nama dan Logo Website</h3>
                <div class="card-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Nama Web</td>
                                <td>Tes Utama</td>
                                <td>Logo Square</td>
                                <td>Logo Expand</td>
                            </tr>
                            <tr>
                                <td>{{$site->name}}</td>
                                <td>{{$site->blueprint}}</td>
                                <td><img src="{{$site->logo_square}}" width="50" height="50"></td>
                                <td><img src="{{$site->logo_expand}}" width="150" height="50"></td>
                            </tr>
                        </tbody>

                    </table>
                    
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-1">
                        <span class="bi bi-pencil-square"></span>
                    </button>
                    <div class="modal fade" id="modal-1" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Edit Nama dan Log Website</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('site.update1', ['site_id' => $site->id])}}" method="POST" enctype="multipart/form-data">
                                    @csrf                                          
                                    @method('PUT')
                                    <div class="row mb-3">
                                      <label for="inputText" class="col-sm-2 col-form-label">Nama Web</label>
                                      <div class="col-sm-10">
                                        <input type="text" name="name" class="form-control" value="{{$site->name}}">
                                      </div>
                                    </div>
                                                                        
                                    <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Logo Square</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="logo_square" class="form-control">
                                        </div>
                                      </div>
                                      <div class="row mb-3">
                                        <label for="inputText" class="col-sm-2 col-form-label">Logo Expand</label>
                                        <div class="col-sm-10">
                                          <input type="file" name="logo_expand" class="form-control">
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
                </div>      
            </div>
        </div>

        <div class="col-lg-12">
            <div class="info-box card">
                <h3>Menu</h3>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Urutan</th>
                                <th>Nama (Desktop)</th>
                                <th>Nama (Mobile)</th>
                                <th>Nama (Dashboard)</th>
                                <th>Icon (Dashboard)</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $item)    
                                <tr>
                                    <td>{{$item->ordering}}</td>
                                    <td>{{$item->sidebar_name}}</td>
                                    <td>{{$item->mobile_name}}</td>
                                    <td>{{$item->dashboard_name}}</td>
                                    <td>
                                        @if ($item->dashboard_icon)
                                            <img src="{{$item->dashboard_icon}}" width="50" height="50">
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-2-{{$item->menu_id}}">
                                            <span class="bi bi-pencil-square"></span>
                                        </button>
                                    </td>
                                    <div class="modal fade" id="modal-2-{{$item->menu_id}}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Edit Menu</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('site.update-menu', ['site_id' => $site->id])}}" method="POST">
                                                    @csrf                                          
                                                    @method('PUT')
                                                    <input type="hidden" name="menu_id" value="{{$item->menu_id}}">
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Urutan</label>
                                                        <div class="col-sm-10">
                                                        <input type="number" name="ordering" class="form-control" value="{{$item->ordering}}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Nama (Desktop)</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" name="sidebar_name" class="form-control" value="{{$item->sidebar_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Nama (Mobile)</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" name="mobile_name" class="form-control" value="{{$item->mobile_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Nama (Dashboard)</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" name="dashboard_name" class="form-control" value="{{$item->dashboard_name}}">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <label for="inputText" class="col-sm-2 col-form-label">Icon (Dashboard)</label>
                                                        <div class="col-sm-10">
                                                        <input type="text" name="dashboard_icon" class="form-control" value="{{$item->dashboard_icon}}">
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
                    </table>
                </div>                
            </div>
        </div>

        <div class="col-lg-12">
            <div class="info-box card">
                <h3>Warna Komponen</h3>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Nama Komponen</th>
                                <th>Warna</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($colors as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <input type="color" class="form-control form-control-color" id="exampleColorInput" value="{{$item->value}}" disabled>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-3-{{$item->key}}">
                                            <span class="bi bi-pencil-square"></span>
                                        </button>
                                    </td>
                                    <div class="modal fade" id="modal-3-{{$item->key}}" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Edit Warna {{$item->name}}</h5>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('site.update-color', ['site_id' => $site->id])}}" method="POST">
                                                    @csrf                                          
                                                    @method('PUT')
                                                    <input type="hidden" name="key" value="{{$item->key}}">
                                                    <div class="row mb-3">
                                                        <div class="col-sm-10">
                                                            <input type="color" name="value" class="form-control form-control-color" value="{{$item->value}}">                            
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
                    </table>
                              
            </div>
        </div>
    </div>

</section>
@endsection
