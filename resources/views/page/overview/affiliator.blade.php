
<!-- Affiliate Link Card -->
<div class="col-xxl-4 col-xl-12">
    <div class="card info-card">
        <div class="card-body">
            <h5 class="card-title">My Link</h5>

            <div class="d-flex align-items-center">
                <div class="ps-3 w-100">
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <a href="https://bio.jagotes.id/u/{{ auth()->user()->referral_code }}" 
                        id="affiliateLink" 
                        target="_blank" 
                        class="text-primary small fw-bold pt-2 ps-1 text-decoration-none">
                        https://bio.jagotes.id/u/{{ auth()->user()->referral_code }}
                        </a>
                        
                        <button type="button" 
                                id="btnCopyLink" 
                                class="btn btn-sm btn-outline-secondary py-0 px-2 mt-1" 
                                title="Salin Link">
                            <i class="bi bi-clipboard"></i> <span style="font-size: 0.75rem;">Salin</span>
                        </button>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top">
                    <a href="{{ url('biolink/settings') }}" class="btn btn-sm btn-primary w-100 d-flex align-items-center justify-content-center gap-2 py-2 shadow-sm">
                        <i class="bi bi-sliders"></i>
                        <span class="fw-bold">Kustomisasi Urutan Link Bio</span>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- End Affiliate Link Card -->
<div class="col-xxl-4 col-xl-4 mb-3">
    <select id="timeFilter" class="form-select shadow-sm" style="cursor: pointer;">
        @foreach($timeDimensions as $time)
            <option value="{{ $time->id }}" 
                    data-start="{{ $time->start_date }}" 
                    data-end="{{ $time->end_date }}">
                {{ $time->nama_periode }} </option>
        @endforeach
    </select>
</div>
<div class="col-xxl-4 col-md-12">
    <div class="card info-card revenue-card">
        <div class="card-body">
            <h5 class="card-title">Tier & Komisi Performa</h5>
            <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center" style="color: #ffc107; background-color: #fff8e1;">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="ps-3">
                    <h6 id="tier">Tier -</h6>
                    <span class="text-muted small pt-2 d-block">Total Poin: <strong id="total_point">-</strong></span>
                    <span class="text-muted small pt-1 d-block">Bagi Hasil: <strong id="percent_komisi" class="text-success">-</strong></span>
                    <span class="text-muted small pt-1 d-block">Estimasi Komisi: <strong id="komisi" class="text-primary">-</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xxl-8 col-md-12">
    <div class="card info-card">
        <div class="card-body">
            <h5 class="card-title">Rincian Performa Bulan Ini</h5>
            <div class="row text-center mt-3">
                <div class="col-4 border-end">
                    <h6 class="text-muted mb-1" style="font-size: 0.9rem;">User Baru</h6>
                    <h4 id="new_users" class="fw-bold text-primary">-</h4>
                    <span class="badge bg-light text-dark">x1 Poin</span>
                </div>
                <div class="col-4 border-end">
                    <h6 class="text-muted mb-1" style="font-size: 0.9rem;">Ikut Tryout</h6>
                    <h4 id="tryout" class="fw-bold text-success">-</h4>
                    <span class="badge bg-light text-dark">x3 Poin</span>
                </div>
                <div class="col-4">
                    <h6 class="text-muted mb-1" style="font-size: 0.9rem;">Beli Premium</h6>
                    <h4 id="premium" class="fw-bold text-warning">-</h4>
                    <span class="badge bg-light text-dark">x30 Poin</span>
                </div>
            </div>
        </div>
    </div>
</div>

@push('overview-scripts')
<script>
  $(document).ready(function() {
    
    // Fungsi untuk memanggil AJAX
    function getData(start, end){
        $.ajax({
          url: "{{ url('affiliator-performance/overview') }}", 
          method: 'GET', 
          cache: false,
          data: {
            start_date: start, // Format disesuaikan dengan isi database (umumnya YYYY-MM-DD)
            end_date: end
          },
          success: function(data) {
            // Memasukkan data JSON ke dalam elemen HTML
              $('#tier').html('Tier ' + data.tier);
              $('#total_point').html(data.total_point);
              
              $('#new_users').html(data.new_users);
              $('#tryout').html(data.tryout);
              $('#premium').html(data.premium);
              $('#percent_komisi').html(data.percent_komisi + "%");
              $('#jumlah_komisi').html(rupiah(data.komisi));
          },
          error: function(xhr, status, error) {
            console.error('Error:', error);
          }
        });
    }

    // 1. Ambil data saat halaman pertama kali dimuat (berdasarkan option pertama/terpilih)
    let initialOption = $('#timeFilter option:selected');
    if(initialOption.length > 0) {
        getData(initialOption.data('start'), initialOption.data('end'));
    }

    // 2. Event listener ketika dropdown diubah
    $('#timeFilter').on('change', function() {
        let selectedOption = $(this).find('option:selected');
        let startDate = selectedOption.data('start');
        let endDate = selectedOption.data('end');
        
        getData(startDate, endDate);
    });

    $('#btnCopyLink').on('click', function() {
        // Ambil text URL dari tag link anchor
        let linkText = $('#affiliateLink').attr('href');
        
        // Proses menyalin teks menggunakan API Clipboard modern browser
        navigator.clipboard.writeText(linkText).then(function() {
            // Simpan elemen tombol ke variabel
            let btn = $('#btnCopyLink');
            
            // Ubah tampilan tombol saat berhasil disalin
            btn.removeClass('btn-outline-secondary').addClass('btn-success');
            btn.html('<i class="bi bi-check-lg"></i> <span style="font-size: 0.75rem;">Tersalin!</span>');
            
            // Kembalikan tampilan tombol ke semula setelah 2 detik
            setTimeout(function() {
                btn.removeClass('btn-success').addClass('btn-outline-secondary');
                btn.html('<i class="bi bi-clipboard"></i> <span style="font-size: 0.75rem;">Salin</span>');
            }, 2000);
            
        }).catch(function(err) {
            console.error('Gagal menyalin link: ', err);
        });
    });

  });
</script>
@endpush
