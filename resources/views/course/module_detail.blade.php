@extends('layouts.app')

@section('content')
<div class="pagetitle">
    <h1>File Pendukung</h1>
</div>

<button class="btn btn-secondary mb-3" onclick="history.back()">
    <i class="bi bi-arrow-left-square"></i>
</button>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<section class="section dashboard">
    <div class="row">
        <div class="col-12">
            <div class="card info-card">
                <div class="card-body">
                    <h5 class="card-title">{{ $module->title }}</h5>

                    <button type="button" class="btn btn-primary mb-3"
                            data-bs-toggle="modal" data-bs-target="#modalAdd">
                        Tambah File
                    </button>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($collection as $item)
                            <tr>
                                <td>
                                    <a href="{{ route('course-module-detail.download', $item->id) }}"
                                       target="_blank" rel="noopener">
                                        {{ $item->name }}
                                    </a>
                                </td>
                                <td align="right" style="width:1px; white-space:nowrap;">
                                    <button type="button" class="btn btn-warning"
                                            data-bs-toggle="modal" data-bs-target="#modalEdit{{ $item->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>

                                    <form action="{{ route('course-module-detail.delete', $item->id) }}"
                                          method="POST" class="d-inline"
                                          onsubmit="return confirm('Hapus file ini? File akan dihapus permanen.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center text-muted">Belum ada file.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @foreach ($collection as $item)
        <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form action="{{ route('course-module-detail.update', $item->id) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="modal-header">
                            <h5 class="modal-title">Ganti File</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">File Saat Ini</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $item->name }}" disabled>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">File Baru</label>
                                <div class="col-sm-9">
                                    <input type="file" name="file" class="form-control" required>
                                    <small class="text-muted">Nama file mengikuti file yang diunggah.</small>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('course-module-detail.add') }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="module_id" value="{{ $module->id }}">

                    <div class="modal-header">
                        <h5 class="modal-title">Tambah File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">File</label>
                            <div class="col-sm-9">
                                <input type="file" name="file" class="form-control" required>
                                <small class="text-muted">Nama file mengikuti file yang diunggah. Maks 50MB.</small>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop