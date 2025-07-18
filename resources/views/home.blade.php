@extends('layouts.app')
@section('css')<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@stop
@section('content')
<section class="section dashboard">
    <div class="row">
        <!-- Affiliate Link Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">MyLink</h5>

                    <div class="d-flex align-items-center">
                        
                        <div class="ps-3">
                          @if (auth()->user()->role == 'partner')
                          @foreach ($sites as $item)
                            <p class="text-muted small pt-2 ps-1">{{$item->domain_1}}</p>
                          @endforeach
                            
                          @else
                            <span class="text-muted small pt-2 ps-1">https://mylink.kliktes.com/u/{{auth()->user()->referral_code}}</span>
                            <ul>
                              <li class="text-muted small pt-2 ps-1">https://portal-bumn.jagotes.id/register?code={{auth()->user()->referral_code}}</li>                              
                              <li class="text-muted small pt-2 ps-1">https://app.goptn.id/register?code={{auth()->user()->referral_code}}</li>
                              <li class="text-muted small pt-2 ps-1">https://portal-lpdp.jagotes.id/register?code={{auth()->user()->referral_code}}</li>
                              <li class="text-muted small pt-2 ps-1">https://portal-cpns.jagotes.id/register?code={{auth()->user()->referral_code}}</li>
                              <li class="text-muted small pt-2 ps-1">https://portal-pppk.jagotes.id/register?code={{auth()->user()->referral_code}}</li>
                              <li class="text-muted small pt-2 ps-1">https://portal-kedinasan.jagotes.id/register?code={{auth()->user()->referral_code}}</li>
                            </ul>
                          @endif                         
                            
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- End Affiliate Link Card -->
        <div class="col-xxl-4 col-xl-8 mb-3">
            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
              <span></span> <b class="fa fa-caret-down"></b>
            </div>
        </div>
        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">User Terdaftar</h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6 id="pendaftar"></h6>
                            
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <!-- End Customers Card -->

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
            <div class="card info-card sales-card">
              <div class="card-body">
                <h5 class="card-title">Item Terjual</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="sales"></h6>
                    
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Komisi</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6 id="komisi"></h6>
                    
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

    </div>
</section>
@endsection
@section('js')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        new_start = start;
        new_end = end;
        $.ajax({
          url: "{{url('home')}}", // The URL to send the request to
          method: 'GET', // Specify the HTTP method as GET
          cache: false,
          data: {
            start: start.format('YYYY-MM-DD'),
            end: end.format('YYYY-MM-DD')
          },
          success: function(data) {
            $('#pendaftar').html(data.pendaftar)
            $('#sales').html(data.sales)
            $('#komisi').html(data.komisi)
          },
          error: function(xhr, status, error) {
            // Handle any errors that occur during the request
            console.error('Error:', error);
          }
        });
    }
  });
</script>
@endsection
