@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
@endsection
@section('content')
<div class="pagetitle">
    <h1>Pendaftar</h1>
    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>Layanan</th>
                            <th>Total Pendaftar</th>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->tenant}}</td>
                                    <td>{{$item->jlh}}</td>
                                </tr>
                            @endforeach
                        </tbody>                        
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                    <table class="table p-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Email</th>
                                <th>Layanan</th>
                                <th>Tanggal Daftar</th>
                                <th>Terakhir Login</th>                    
                            </tr>
                        </thead>
                        <tbody>
                        
                        </tbody>
                    </table>
                </div>
            </div>            
        </div>
    </div>
</section>
@endsection

@section('js')
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script>
jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });    

    $('.p-datatable thead tr:eq(0) th').each(function(index) {
      var col = [0, 1, 2, 3];
      if (col.includes(index)) {
        var title = $(this).text();
        $(this).html(title + '<br><input type="text" style="width:100%;" placeholder="Search" />');
      }
    });

    table = $('.p-datatable').DataTable({ 
        processing: true,
        serverSide: true,
        ordering: false,       
        ajax: {
            url: '{{ route("pendaftar") }}',
            error: function (xhr, error, code) {
                alert(xhr.responseText);
            }
        },
        columns: [
            {data: 'user_name', name: 'user_name'},
            {data: 'telp', name: 'telp'},
            {data: 'email', name: 'email'},
            {data: 'tenant', name: 'tenant'},
            {data: 'created_at', name: 'created_at'},
            {data: 'last_login_at', name: 'last_login_at'},
        ],
        columnDefs: [{
            "width": "200px",
            "targets": [0]
          }
        ],
        initComplete: function(index) {
          // Apply the search
          this.api().columns().every(function() {
            var that = this;

            $('input', this.header()).on('keyup change clear', function() {
              if (that.search() !== this.value) {
                that
                  .search(this.value)
                  .draw();
              }
            });
          });
        },
    });
});
</script>
@endsection