@extends('layouts.app')

@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">Atur Tampilan Website</h5>
                    <div class="d-flex align-items-center">                        
                        <div class="ps-3">
                            @foreach ($sites as $item)
                            <p>
                                <a href="{{route('site-appearance', ['site_id' => $item->id])}}">{{$item->domain_1}}</a>                            
                            </p>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
