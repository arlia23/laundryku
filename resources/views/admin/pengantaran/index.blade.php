 @extends('layouts.app')

@section('title', 'Data Pengantaran - LaundryKu')
@section('page-title', 'Data Pengantaran')

@section('content')

<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold mb-1">Manajemen Pengantaran</h4>
        <p class="text-muted mb-0">Pantau proses penjemputan dan pengantaran pesanan laundry.</p>
    </div>

    <a href="{{ route('admin.pengantaran.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i>
        Tambah Pengantaran
    </a>
</div>

    {{-- Ringkasan --}}
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Total Pengantaran</div>
                    <h3 class="fw-bold mb-0">{{ DB::table('deliveries')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Menunggu Penjemputan</div>
                    <h3 class="fw-bold text-warning mb-0">
                        {{ DB::table('deliveries')->where('pickup_status', 'pending')->count() }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small mb-2">Belum Diantarkan</div>
                    <h3 class="fw-bold text-primary mb-0">
                        {{ DB::table('deliveries')->where('delivery_status', 'pending')->count() }}
                    </h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Pengantaran --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold">Daftar Pengantaran</h5>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Kode Pesanan</th>
                            <th>Pelanggan</th>
                            <th>Kurir</th>
                            <th>Penjemputan</th>
                            <th>Pengantaran</th>
                            <th>Total Pesanan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pengantaran as $item)
                            <tr>
                                <td>{{ $loop->iteration + ($pengantaran->currentPage() - 1) * $pengantaran->perPage() }}</td>

                                <td>
                                    <span class="fw-semibold">{{ $item->order_code }}</span>
                                </td>

                                <td>{{ $item->nama_pelanggan }}</td>

                                <td>
                                    {{ $item->nama_kurir ?? 'Belum ditentukan' }}
                                </td>

                                <td>
                                    @if($item->pickup_status == 'picked_up')
                                        <span class="badge bg-success">Sudah Dijemput</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>

                                <td>
                                    @if($item->delivery_status == 'delivered')
                                        <span class="badge bg-success">Sudah Diantar</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @endif
                                </td>

                                <td>
                                    Rp{{ number_format($item->total_price, 0, ',', '.') }}
                                </td>

                                <td>
    <a href="{{ route('admin.pengantaran.show', $item->id) }}"
       class="btn btn-sm btn-info text-white">
        <i class="bi bi-eye me-1"></i>
        Detail
    </a>
</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">
                                    Belum ada data pengantaran.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pengantaran->links() }}
            </div>

        </div>
    </div>

</div>

@endsection