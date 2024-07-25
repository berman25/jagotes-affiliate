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
        @if (!$data->email_verify_at)
        <div class="col-xxl-4 col-xl-12">
            <div class="card">
                <div class="card-body">                    
                    <h5 class="card-title">Verifikasi Email</h5>                    
                    <form action="{{route('email-verification')}}" method="POST">
                        @csrf
                        <div class="row">                        
                            <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required value="{{$data->email_verification}}">                            
                            </div>                       
                            <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                                <button type="submit" class="btn btn-primary" id="cd">Request kode verifikasi</button>
                            </div>
                        </div>
                    </form>
                    @if ($data->email_verification)
                        <p id="otpVerificationForm">Link verifikasi sudah dikirimkan ke email <span id="email" class="text-danger">{{$data->email_verification}}.</span>
                        Request ulang dapat dilakukan dalam <span id="timer">0</span> detik</p>                    
                    @endif                    
                </div>
            </div>
        </div>
        @else
        <div class="col-xxl-4 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Akun Anda sudah terverifikasi</h5>
                    {{-- <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Nama Akun</label>
                            <input type="text" name="name" class="form-control" value="{{$data->name}}" disabled>                            
                        </div>                        
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <label class="form-label">Email</label>
                            <input type="text" name="telp" class="form-control" value="{{$data->email}}" disabled>                            
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        {{-- <div class="col-xxl-4 col-xl-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Rekening</h5>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="bank_name" class="form-control" value="{{$data->bank_name}}" disabled>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="bank_account_number" class="form-control" value="{{$data->bank_account_number}}" disabled>                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
                            <label class="form-label">Atas Nama</label>
                            <input type="text" name="bank_account_name" class="form-control" value="{{$data->bank_account_name}}" disabled>                            
                        </div>
                       
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
        @endif
        
        
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

    if({{$cooldown}}){
        document.getElementById("cd").disabled = true;        
        distance = 20;
        var x = setInterval(function() {
            
            document.getElementById("timer").innerHTML = distance;
            distance = distance - 1;
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("cd").disabled = false;
            }

        }, 1000);
    }
    

    
</script>

@stop