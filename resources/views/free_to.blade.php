@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
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
                    <table class="table table-bordered" id="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Organisasi</th>
                                <th>Jumlah</th>
                                <th>Premium</th>
                                <th>Skor</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->name}} - {{$item->group}}</td>
                                <td>{{$item->tenant_organization}}</td>
                                <td>
                                    <p>Daftar: {{$item->jlh_register}}</p>
                                    <p>Mengerjakan: {{$item->jlh_submit}}</p>
                                    <p>%: {{ number_format($item->jlh_submit*100/$item->jlh_register, 2) }}</p>
                                </td>
                                <td>
                                    <p>Premium: {{$item->jlh_premium}}</p>
                                    <p>%: {{ number_format($item->jlh_submit*100/$item->jlh_register, 2) }}</p>
                                </td>
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
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  $(document).ready(function() {

    $('#data-table').DataTable({
        iDisplayLength: 25,
        ordering: false,
        autoWidth: false,
        columnDefs: [
            { "width": "30%", "targets": 0 }
        ]
    });
});

</script>
@endsection