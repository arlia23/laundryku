
@extends('layouts.app')

@section('title', 'Paket Laundry - LaundryKu')
@section('page-title', 'Paket Laundry')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <h4 class="fw-bold mb-1">Paket Laundry</h4>
            <p class="text-muted mb-0">
                Kelola daftar layanan dan harga laundry per kilogram.
            </p>
        </div>

        <a href="{{ route('admin.paket.create') }}"
           class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Tambah Paket
        </a>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">Daftar Paket Laundry</h6>
        </div>

        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Deskripsi</th>
                            <th>Harga per Kg</th>
                            <th>Durasi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($paket as $item)
                            <tr>
                                <td>
                                    {{ $paket->firstItem() + $loop->index }}
                                </td>

                                <td class="fw-semibold">
                                    {{ $item->name }}
                                </td>

                                <td>
                                    {{ $item->description ?? '-' }}
                                </td>

                                <td class="fw-semibold text-primary">
                                    Rp{{ number_format($item->price, 0, ',', '.') }}/kg
                                </td>

                                <td>
                                    <span class="badge bg-success">
                                        {{ $item->duration }} Hari
                                    </span>
                                </td>

                                <td class="text-center">

                                    <a href="{{ route('admin.paket.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.paket.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline form-hapus-paket"
                                          data-nama="{{ $item->name }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <i class="bi bi-box-seam fs-1 text-muted"></i>
                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada paket laundry.
                                    </p>
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                {{ $paket->links() }}
            </div>

        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-hapus-paket').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;
            const nama = formIni.dataset.nama;

            Swal.fire({
                title: 'Hapus Paket Laundry?',
                html: `
                    <p class="mb-1">Apakah kamu yakin ingin menghapus paket:</p>
                    <strong class="text-danger">${escapeHtml(nama)}</strong>
                    <p class="text-muted small mt-3 mb-0">
                        Pastikan paket ini tidak sedang digunakan dalam pesanan.
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
