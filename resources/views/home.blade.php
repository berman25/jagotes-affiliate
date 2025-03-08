@extends('layouts.app')

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

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

            <div class="card info-card customers-card">
                <div class="card-body">
                    <h5 class="card-title">Total Pendaftar </h5>

                    <div class="d-flex align-items-center">
                        <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people"></i>
                        </div>
                        <div class="ps-3">
                            <h6>{{$pendaftar}}</h6>
                            
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
                <h5 class="card-title">Total Penjualan</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-cart"></i>
                  </div>
                  <div class="ps-3">
                    <h6>{{$sales}}</h6>
                    
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Sales Card -->

          <!-- Revenue Card -->
          <div class="col-xxl-4 col-md-6">
            <div class="card info-card revenue-card">
              <div class="card-body">
                <h5 class="card-title">Total Komisi</h5>

                <div class="d-flex align-items-center">
                  <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-currency-dollar"></i>
                  </div>
                  <div class="ps-3">
                    <h6>@money($komisi)</h6>
                    
                  </div>
                </div>
              </div>

            </div>
          </div><!-- End Revenue Card -->

    </div>
</section>
@endsection
