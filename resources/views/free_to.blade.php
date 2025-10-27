@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/css/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@stop
@section('content')

<div class="pagetitle">
    <h1>Free TO</h1>
    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">       

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Summary</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Group</th>
                                <th>Organisasi</th>
                                <th>Jumlah Peserta</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->name}}</td>
                                <td>{{$item->group}}</td>
                                <td>{{$item->tenant_organization}}</td>
                                <td>{{$item->jlh_participant}}</td>
                                <td>       
                                    <p>Max: {{ number_format($item->max_score, 2) }}</p>
                                    <p>Avg: {{ number_format($item->avg_score, 2) }}</p>
                                    <p>Min: {{ number_format($item->min_score, 2) }}</p>
                                </td>
                                
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


@stop