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
    <h1>Saldo</h1>
    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <!-- Affiliate Link Card -->
        <div class="col-xxl-4 col-xl-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">Saldo Tersedia</h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <h2>@money($saldo)</h2> 
                        {{-- <button class="btn btn-primary" id="withdrawalBtn">Tarik Dana</button> --}}
                    </div>                    

                </div>
            </div>
        </div>
        <!-- End Affiliate Link Card -->

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Riwayat Penarikan</h5>
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Jumlah</th>
                                <th>Rekening Penerima</th>
                                <th>Referensi</th>
                                <th>Status</th>                
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->created_at}}</td>
                                <td>@money($item->amount)</td>
                                <td>                       
                                    {{$item->bank_account["bank_name"] ?? "-"}} <br>
                                    {{$item->bank_account["account_number"] ?? "-"}} <br>
                                    {{$item->bank_account["account_name"] ?? "-"}} <br>
                                </td>
                                <td>{{$item->id}}</td>
                                <td>{{$item->status}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="widthdrawalModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarik Saldo Anda</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="widthdrawalForm">
                     <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Masukkan jumlah untuk ditarik</label>
                            <input type="number" name="amount" class="form-control" placeholder="0" required max="{{$saldo}}">
                            <p><span style="font-size: 12px">@money($saldo) tersedia</span></p>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Penarikan ke</label>
                            <select name="account_number" id="bank-account" class="form-control" required style="width:100%;"></select>
                        </div>
                        <div class="d-grid gap-2 mt-3">
                            <a class="btn btn-outline-primary" id="addBankAccountBtn">Tambahkan rekening bank anda</a>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                   
                </form>
            </div>
            
        </div>
    </div>
</div>

<div class="modal fade" id="addBankAccountModal" aria-modal="true" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Nomor Rekening</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addBankAccountForm">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Nama Pemilik Akun Bank</label>
                            <input type="text" name="account_name" class="form-control">                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Nama Bank</label>
                            <input type="text" name="bank_name" class="form-control">                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <label class="form-label">Nomor Rekening</label>
                            <input type="text" name="account_number" class="form-control">                            
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 text-center mt-3">
                            <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                   
                </form>
            </div>
            
        </div>
    </div>
</div>

@stop

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.1/js/bootstrap-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<script>
    $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    }); 
    $('body').on('click', '#withdrawalBtn', function () {
        if({{$saldo}} < 50000){
            alert('Penarikan minimum adalah Rp50.000')
        }else{

            jQuery('#widthdrawalModal').modal('show')
        }        
    })
    
    $('body').on('click', '#addBankAccountBtn', function () {
        jQuery('#addBankAccountModal').modal('show')      
    })

    $("#addBankAccountForm").validate({
        submitHandler: function(form) {                
            $.ajax({
                data: $('#addBankAccountForm').serialize(),
                url: '{{ route("add-bank-account")}}',
                type: "POST",
                dataType: 'json',            
                success: function (data) {
                    jQuery('#addBankAccountModal').modal('hide');
                    $('#bank-account').trigger('change') 
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    })

    $("#widthdrawalForm").validate({
        submitHandler: function(form) {                
            $.ajax({
                data: $('#widthdrawalForm').serialize(),
                url: '{{ route("withdrawal")}}',
                type: "POST",
                dataType: 'json',            
                success: function (data) {
                    location.reload();
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }
    })

    $('#bank-account').select2({
        dropdownParent: $('#widthdrawalModal'),
        placeholder: 'Pilih Rekening',
        ajax: {
            url: '{{ route("get-bank-account") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    term: params.term
                }
            },

            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.bank_name + " - " + item.account_number + " - " + item.account_name,
                            id: item.account_number
                        }
                    })
                };
            },
            cache: true
        }
    });

    
</script>

@stop