@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@stop
@section('content')
<div class="pagetitle">
    <h1>Transaksi</h1>
    
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
                                <th>Telp</th>
                                {{-- <th>Email</th> --}}                                                                
                                <th>Sumber</th>
                                <th>Nama Produk</th>
                                <th>Penjualan Bersih</th>
                                <th>Pendapatan</th>
                                <th>Tanggal Pembayaran</th>                 
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->user_name}}</td>
                                <td>{{$item->telp}}</td>                                
                                <td>{{$item->source}} ({{$item->source_id}})</td>
                                {{-- <td>{{$item->email}}</td> --}}
                                <td>{{$item->product_name}}</td>
                                <td>@money($item->revenue) <br><span class="badge bg-primary">{{$item->payment_channel}}</span></td>
                                <td>@money($item->komisi) <br><span class="badge bg-primary">{{$item->commission_rate}}%</span></td></td>
                                <td>{{$item->paid_at}}</td>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    var start = moment().subtract(1, 'days').day(1);
    var end = moment();

    $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Minggu Ini': [moment().subtract(1, 'days').day(1), moment()],
            'Minggu Lalu': [moment().subtract(7, 'days').day(1), moment().subtract(7, 'days').day(7)],
            'Bulan Ini': [moment().startOf('month'), moment()],
            'Bulan Lalu': [moment().subtract(1, 'months').startOf('month'), moment().subtract(1, 'months').endOf('month')],
            'Hari Ini': [moment(), moment()],
            'Kemarin': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            // 'LifeTime': [moment("20210101", "YYYYMMDD"), moment()],        

        }
    }, getData);

    function getData(){
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        new_start = start;
        new_end = end;
    }

</script>
@endsection
