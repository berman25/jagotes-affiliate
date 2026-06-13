@extends('layouts.app')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb bg-light p-3 rounded shadow-sm">
            <li class="breadcrumb-item">
                <a href="{{ url('home') }}" class="text-decoration-none d-flex align-items-center gap-1">
                    <i class="bi bi-speedometer2"></i> Dashboard Overview
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <i class="bi bi-gear-fill me-1"></i> Pengaturan Bio Link
            </li>
        </ol>
    </nav>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0 fw-bold">Atur Urutan & Visibilitas Bio Link</h5>
            <small class="text-muted">Geser ikon ☰ untuk mengurutkan. Kategori yang dicentang akan otomatis disimpan sesuai urutannya.</small>
        </div>
        <div class="card-body">
            <form id="sortableForm">
                <ul id="sortable-list" class="list-group mb-3">
                    
                    {{-- Loop data master $categories yang urutannya sudah disesuaikan oleh Controller --}}
                    @foreach($categories as $category)
                        {{-- Cek apakah kategori ini masuk di dalam array 1 dimensi $savedSort (artinya aktif) --}}
                        @php $isActive = in_array($category, $savedSort); @endphp
                        
                        <li class="list-group-item d-flex align-items-center justify-content-between py-3" data-id="{{ $category }}">
                            <div class="d-flex align-items-center">
                                <span class="drag-handle me-3 text-muted" style="cursor: move; font-size: 1.2rem;">☰</span>
                                
                                <div class="form-check text-start mb-0">
                                    <input class="form-check-input category-checkbox" type="checkbox" 
                                           value="{{ $category }}" id="check-{{ $category }}"
                                           {{ $isActive ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" style="cursor: pointer;" for="check-{{ $category }}">
                                        Bimbel {{ $category }}
                                    </label>
                                </div>
                            </div>
                            
                            {{-- Badge status berdasarkan nilai $isActive --}}
                            <span class="badge status-badge {{ $isActive ? 'bg-success' : 'bg-secondary' }}">
                                {{ $isActive ? 'Tampil' : 'Sembunyi' }}
                            </span>
                        </li>
                    @endforeach

                </ul>

                <div class="border-top pt-3 text-end">
                    <button type="button" id="btn-save" class="btn btn-primary px-4">
                        <i class="bi bi-save me-1"></i> Simpan Susunan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const el = document.getElementById('sortable-list');
        
        // Inisialisasi Drag & Drop
        if(el) {
            Sortable.create(el, {
                handle: '.drag-handle',
                animation: 150,
                ghostClass: 'bg-light'
            });
        }

        // Interaksi toggle badge secara realtime saat checkbox dicentang/lepas
        el.addEventListener('change', function(e) {
            if(e.target.classList.contains('category-checkbox')) {
                const badge = e.target.closest('li').querySelector('.status-badge');
                if(e.target.checked) {
                    badge.className = "badge status-badge bg-success";
                    badge.innerText = "Tampil";
                } else {
                    badge.className = "badge status-badge bg-secondary";
                    badge.innerText = "Sembunyi";
                }
            }
        });

        // AJAX submit data urutan kategori
        document.getElementById('btn-save').addEventListener('click', function() {
            const items = el.querySelectorAll('li');
            const sortedActiveCategories = [];

            items.forEach(item => {
                const checkbox = item.querySelector('.category-checkbox');
                // Hanya string nama kategori yang dicentang yang dimasukkan ke array
                if (checkbox.checked) {
                    sortedActiveCategories.push(item.getAttribute('data-id'));
                }
            });

            // Kirim data via Fetch API
            fetch("{{ url('biolink/save-settings') }}", {
                method: "put",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    categories: sortedActiveCategories
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.status === 'success') {
                    alert(data.message);
                    window.location.reload();
                }
            })
            .catch(error => console.error('Error:', error));
        });
    });
</script>
@endsection