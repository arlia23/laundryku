
@extends('layouts.app')

@section('title', 'Data Mesin - LaundryKu')
@section('page-title', 'Manajemen Mesin')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Data Mesin Laundry</h4>
            <p class="text-muted mb-0">
                Kelola seluruh mesin yang digunakan dalam operasional LaundryKu.
            </p>
        </div>

        <a href="{{ route('admin.mesin.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Mesin
        </a>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-gear-fill text-primary fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total Mesin</p>
                        <h4 class="fw-bold mb-0">{{ $mesin->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success bg-opacity-10 p-3">
                        <i class="bi bi-check-circle-fill text-success fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Mesin Tersedia</p>
                        <h4 class="fw-bold mb-0">
                            {{ DB::table('machines')->where('status', 'available')->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-warning bg-opacity-10 p-3">
                        <i class="bi bi-tools text-warning fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Dalam Perawatan</p>
                        <h4 class="fw-bold mb-0">
                            {{ DB::table('machines')->where('status', 'maintenance')->count() }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Tabel Mesin --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Daftar Mesin</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Nama Mesin</th>
                        <th>Jenis Mesin</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mesin as $index => $item)
                        <tr>
                            <td class="ps-4">
                                {{ $mesin->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="fw-semibold">{{ $item->name }}</div>
                            </td>

                            <td>{{ $item->type }}</td>

                            <td>
                                @if($item->status == 'available')
                                    <span class="badge bg-success bg-opacity-10 text-success">
                                        Tersedia
                                    </span>
                                @elseif($item->status == 'in_use')
                                    <span class="badge bg-primary bg-opacity-10 text-primary">
                                        Sedang Digunakan
                                    </span>
                                @else
                                    <span class="badge bg-warning bg-opacity-10 text-warning">
                                        Dalam Perawatan
                                    </span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('admin.mesin.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.mesin.destroy', $item->id) }}"
                                          method="POST"
                                          class="form-hapus-mesin"
                                          data-nama="{{ $item->name }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="bi bi-gear text-muted fs-1"></i>
                                <p class="text-muted mt-2 mb-1">
                                    Belum ada data mesin laundry.
                                </p>
                                <a href="{{ route('admin.mesin.create') }}">
                                    Tambahkan mesin pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="card-footer bg-white border-0 py-3">
            {{ $mesin->links() }}
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-hapus-mesin').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;
            const nama = formIni.dataset.nama;

            Swal.fire({
                title: 'Hapus Mesin?',
                html: `
                    <p class="mb-1">Apakah kamu yakin ingin menghapus mesin:</p>
                    <strong class="text-danger">${escapeHtml(nama)}</strong>
                    <p class="text-muted small mt-3 mb-0">
                        Mesin yang masih digunakan dalam pesanan tidak dapat dihapus.
                    </p>
                `,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: '<i class="bi bi-trash me-1"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#64748b',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'rounded-4',
                    title: 'fw-bold',
                    confirmButton: 'rounded-3 px-4',
                    cancelButton: 'rounded-3 px-4'
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    formIni.submit();
                }
            });
        });

    });

    function escapeHtml(text) {
        const element = document.createElement('div');
        element.textContent = text;
        return element.innerHTML;
    }

});
</script>
@endpush
