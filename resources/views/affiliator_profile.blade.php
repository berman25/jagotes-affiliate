@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')


@stop
@section('content')

<div class="pagetitle">
    <h1>Pengaturan Akun</h1>
    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profil Anda</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" value="{{$data->name}}" disabled>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6">
                            <label class="form-label">Kode Referral</label>
                            <input type="text" class="form-control" value="{{$data->referral_code}}" disabled>                            
                        </div>
                       <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{$data->email}}" disabled>                            
                        </div>
                        
                        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                            <label class="form-label">Komisi</label>
                            <input type="text" class="form-control" value="{{$data->commission}}%" disabled>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Akun Jagotes</h5>
                    @if ($data->jagotes_kerja_acc_id)
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Email</label>
                            <input type="text" class="form-control" value="{{$data->email}}" disabled>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 mt-3">
                            <label class="form-label">Password</label>
                            <input type="text" class="form-control" value="{{$data->master_password}}" disabled>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <label class="form-label">Masa Aktif</label>
                            <ul class="list-group">
                                @foreach ($masa_aktif as $key => $value)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{$key}}
                                <span class="badge bg-primary rounded-pill">{{$value}} Hari</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>               
                        
                    </div>
                    @else
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="button" class="btn btn-primary">Tambahkan Akun</button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });
    

    $("#emailVerificationForm").validate({
        submitHandler: function(form) {                
            $.ajax({
                data: $('#emailVerificationForm').serialize(),
                url: '{{ route("email-verification")}}',
                type: "POST",
                dataType: 'json',            
                success: function (data) {
                    $("#emailVerificationForm").hide()
                    $("#email").text(data)
                    $("#otpVerificationForm").show()
                    
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    })

    
</script>

@stop