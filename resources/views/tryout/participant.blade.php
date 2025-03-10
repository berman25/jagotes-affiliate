@extends('layouts.app')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
<div class="pagetitle d-flex">
    <button class="btn btn-secondary mb-3" onclick="history.back()"><i class="bi bi-arrow-left-square"></i></button>

    <h1>Pendaftar</h1>    
</div><!-- End Page Title -->
<section class="section">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{$tryout_package->name}}</h5>
                    <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#basicModal">
                        Assign Peserta
                      </button>
                    <table class="table p-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Telp</th>
                                <th>Email</th>
                                <th>Jumlah Pembayaran</th>
                                <th>Tanggal Pembayaran</th>             
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
<div class="modal fade" id="basicModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambahkan peserta</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form class="row g-3" id="assign-user">
                <div class="col-md-12">                    
                    <input type="hidden" name="product_id" value="{{$tryout_package->product_id}}">                
                    <label class="form-label">Siswa</label>
                    <select class="form-control" name="user_id" id="get-user"style="width:100%;" required="true"></select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">Save
                    </button>
                </div>
            </form>
        </div>        
      </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
jQuery(document).ready(function($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });    

    $('.p-datatable thead tr:eq(0) th').each(function(index) {
      var col = [0, 1, 2];
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
            url: '{{ url("/tryout/participant")}}/'+{{$tryout_package->id}},
            error: function (xhr, error, code) {
                alert(xhr.responseText);
            }
        },
        columns: [
            {data: 'user_name', name: 'user_name'},
            {data: 'telp', name: 'telp'},
            {data: 'email', name: 'email'},
            {data: 'amount', name: 'amount'},
            {data: 'paid_at', name: 'paid_at'},
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


    $("#assign-user").validate({        
        submitHandler: function(form) {
                        
            $.ajax({
                data: $('#assign-user').serialize(),
                url: "{{route('assign-user')}}",
                type: "post",
                dataType: 'json',            
                success: function (data) {
                    jQuery('#basicModal').modal('hide');
                    table.draw()
                    $('#get-user').empty().trigger('change');
                },
                error: function (xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        }        
    });

    $('#get-user').select2({
        dropdownParent: $('#basicModal'),
        placeholder: 'Pilih...',
        ajax: {
          url: "{{ route('get.user') }}",
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
                  text: item.email + ' (' + item.user_name + ')',
                  id: item.user_id
                }
              })
            };
          },
          cache: true
        }
      });
});
</script>
@endsection