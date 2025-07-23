@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap4.min.css">
@stop
@section('content')
<div class="pagetitle">
    <h1>Affiliator Performance</h1>
    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    {{-- <h5 class="card-title">Datatables</h5>
                    <p>Add lightweight datatables to your project with using the <a href="https://github.com/fiduswriter/Simple-DataTables" target="_blank">Simple DataTables</a> library. Just add <code>.datatable</code> class name to any table you wish to conver to a datatable. Check for <a href="https://fiduswriter.github.io/simple-datatables/demos/" target="_blank">more examples</a>.</p>
     --}}
                    <!-- Table with stripped rows -->
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kode Referral</th>                                                             
                                <th>Jumlah Pendaftar</th>
                                <th>Jumlah Transaksi</th>
                                <th>Omset</th>
                                <th>Komisi</th>
                                <th>Jumlah Penarikan</th>  
                                <th>Sisa Saldo</th>               
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td><a href="{{url('/affiliator-profile').'/'.$item->referral_code}}" target="_blank" rel="noopener noreferrer">{{$item->name}}</a>
                                    
                                </td>
                                <td>{{$item->referral_code}}</td>                                
                                <td>{{$item->jlh_pendaftar}}</td>
                                <td>{{$item->jlh_trx}}</td>
                                <td>@money($item->omset)</td>
                                <td>@money($item->commission)</td>
                                <td>@money($item->withdrawal)</td>
                                <td>@money($item->remaining_saldo)</td>
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
