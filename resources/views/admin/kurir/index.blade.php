
@extends('layouts.app')

@section('title', 'Data Kurir - LaundryKu')
@section('page-title', 'Manajemen Kurir')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold mb-1">Data Kurir</h4>
            <p class="text-muted mb-0">
                Kelola akun dan informasi kurir LaundryKu.
            </p>
        </div>

        <a href="{{ route('admin.kurir.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg me-1"></i>
            Tambah Kurir
        </a>
    </div>

    {{-- Statistik --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary bg-opacity-10 p-3">
                        <i class="bi bi-people-fill text-primary fs-3"></i>
                    </div>
                    <div>
                        <p class="text-muted mb-1">Total Kurir</p>
                        <h4 class="fw-bold mb-0">{{ $kurir->total() }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Kurir --}}
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white border-0 py-3">
            <h5 class="fw-bold mb-0">Daftar Kurir</h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="ps-4">No.</th>
                        <th>Nama Kurir</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Alamat</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($kurir as $index => $item)
                        <tr>
                            <td class="ps-4">
                                {{ $kurir->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                         style="width: 38px; height: 38px;">
                                        <i class="bi bi-person-fill"></i>
                                    </div>

                                    <span class="fw-semibold">{{ $item->name }}</span>
                                </div>
                            </td>

                            <td>{{ $item->email }}</td>

                            <td>{{ $item->phone ?: '-' }}</td>

                            <td>
                                <span class="d-inline-block text-truncate"
                                      style="max-width: 180px;"
                                      title="{{ $item->address }}">
                                    {{ $item->address ?: '-' }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    {{-- Detail --}}
                                    <a href="{{ route('admin.kurir.show', $item->id) }}"
                                       class="btn btn-sm btn-outline-info"
                                       title="Detail Kurir">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.kurir.edit', $item->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit Kurir">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form action="{{ route('admin.kurir.destroy', $item->id) }}"
                                          method="POST"
                                          class="form-hapus-kurir"
                                          data-nama="{{ $item->name }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger"
                                                title="Hapus Kurir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people text-muted fs-1"></i>

                                <p class="text-muted mt-2 mb-1">
                                    Belum ada akun kurir.
                                </p>

                                <a href="{{ route('admin.kurir.create') }}">
                                    Tambahkan kurir pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        {{-- Pagination --}}
        <div class="card-footer bg-white border-0 py-3">
            {{ $kurir->links() }}
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-hapus-kurir').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;
            const nama = formIni.dataset.nama;

            Swal.fire({
                title: 'Hapus Akun Kurir?',
                html: `
                    <p class="mb-1">Apakah kamu yakin ingin menghapus akun kurir:</p>
                    <strong class="text-danger">${escapeHtml(nama)}</strong>
                    <p class="text-muted small mt-3 mb-0">
                        Tugas pengantaran yang terkait akan kehilangan penugasan kurir ini.
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
