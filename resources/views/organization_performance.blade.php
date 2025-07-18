@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
@stop
@section('content')
<section class="section dashboard">
    <div class="row">
        <div class="col-xxl-4 col-xl-8 mb-3">
            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
              <span></span> <b class="fa fa-caret-down"></b>
            </div>
        </div>

        <!-- Performance Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">Organization Performance</h5>

                    <table id="sales" class="table">
                      <thead>
                          <tr>
                              <th>Tanggal</th>
                              <th>Tenant</th>                              
                              <th>User Baru</th>
                              <th>Invoice Create</th>
                              <th>Paid</th>
                              <th>Omset</th>
                          </tr>
                      </thead>
                  </table>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
  $(document).ready(function() {
    var start = moment().subtract(1, 'months');
    var end = moment();

    // $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    getData(start, end)
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

    

    function getData(start, end){
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        // if ($.fn.dataTable.isDataTable('#sales')) {
        //     $('#sales').DataTable().clear().destroy();
        // }
        // $.ajax({
        //   url: '{{ url("/organization-perfomance") }}',
        //     data: {
        //         start: start.format('YYYY-MM-DD'),
        //         end: end.format('YYYY-MM-DD')
        //     },
        //   success: function(data) {
        //     alert("success")
        //   },
        //   error: function(xhr, status, error) {
        //     // Handle any errors that occur during the request
        //     console.error('Error:', error);
        //   }
        // });
        $('#sales').DataTable({
            iDisplayLength: 25,
            ordering: false,
            info: false,
            ajax: {
                url: '{{ url("/organization-perfomance") }}',
                data: {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD')
                }
            },
            columns: [
                { data: 'tgl', name: 'tgl', render: function(data, type, row, meta) {
                        return moment(data).format('DD/MM/YYYY');
                    }
                },
                { data: 'tenant_site_id', name: 'tenant_site_id'  },                
                { data: 'registered_users', name: 'registered_users'  },
                { data: 'invoice_create', name: 'invoice_create' },
                { data: 'paid', name: 'paid'  },
                { data: 'omset', name: 'omset'  },
            ]
        });
    }
  });
</script>
@endsection
