
@extends('layouts.app')

@section('title', 'Data Pelanggan - LaundryKu')
@section('page-title', 'Data Pelanggan')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
    <div>
        <h4 class="fw-bold mb-1">Data Pelanggan</h4>
        <p class="text-muted mb-0">
            Kelola seluruh data pelanggan LaundryKu.
        </p>
    </div>

    <a href="{{ route('admin.pelanggan.create') }}"
       class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Pelanggan
    </a>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 14px;">
    <div class="card-body p-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Daftar Pelanggan</h5>
            <span class="badge bg-primary">
                {{ $pelanggan->total() }} Pelanggan
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">

                <thead class="table-light">
                    <tr>
                        <th>No.</th>
                        <th>Nama Pelanggan</th>
                        <th>Email</th>
                        <th>No. Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pelanggan as $item)
                        <tr>
                            <td>
                                {{ $pelanggan->firstItem() + $loop->index }}
                            </td>

                            <td class="fw-semibold">
                                {{ $item->name }}
                            </td>

                            <td>{{ $item->email }}</td>

                            <td>{{ $item->phone ?? '-' }}</td>

                            <td>{{ $item->address ?? '-' }}</td>

                            <td>
                                <div class="d-flex gap-2">

                                    <a href="{{ route('admin.pelanggan.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning"
                                       title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    <form action="{{ route('admin.pelanggan.destroy', $item->id) }}"
                                          method="POST"
                                          class="form-hapus-pelanggan"
                                          data-nama="{{ $item->name }}">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-people fs-1 text-muted"></i>
                                <p class="text-muted mt-2 mb-0">
                                    Belum ada data pelanggan.
                                </p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="mt-3">
            {{ $pelanggan->links() }}
        </div>

    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.form-hapus-pelanggan').forEach(function(form) {

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formIni = this;
            const nama = formIni.dataset.nama;

            Swal.fire({
                title: 'Hapus Pelanggan?',
                html: `
                    <p class="mb-1">Kamu yakin ingin menghapus pelanggan:</p>
                    <strong class="text-danger">${escapeHtml(nama)}</strong>
                    <p class="text-muted small mt-3 mb-0">
                        Data pelanggan akan dihapus dari sistem.
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
