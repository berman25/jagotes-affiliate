@extends('layouts.app')
@section('css')<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('content')
<section class="section dashboard">
    <div class="row">
        @if (auth()->user()->role == 'partner')
            @include('page.overview.partner')
        @else
            @include('page.overview.affiliator')
        @endif
    </div>
</section>
@endsection


@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@stack('overview-scripts')
@endsection