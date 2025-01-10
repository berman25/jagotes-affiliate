@extends('layouts.app')

@section('content')
<section class="section contact">
    <a class="mb-3" href="#" onclick="history.back()"><-kembali</a>
    <div class="row">
        <div class="col-lg-6">
            <div class="info-box card">
                {{-- <i class="bi bi-clock"></i> --}}
                <h3>Nama Web</h3>
                <p>{{$site->name}}</p>
                <h3>Blueprint</h3>
                <p>{{$site->blueprint}}</p>
                <h3>Logo Square</h3>
                <img src="{{$site->logo_square}}" width="100" height="100">
                <h3>Logo Expand</h3>
                <img src="{{$site->logo_expand}}" width="300" height="100">
            </div>
        </div>
        
        <div class="col-lg-6">
            <div class="info-box card">
                {{-- <i class="bi bi-envelope"></i> --}}
                <h3>Komponen Warna</h3>
                @foreach ($site->color as $key => $value)
                    <p>{{$key}} : {{$value}}</p>
                @endforeach
            </div>
        </div>
    </div>

</section>
@endsection
