@extends('layouts.app')
@section('title', 'Rekening')

@section('main-content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">💳 Daftar Rekening</h2>
        <a href="{{ route('accounts.create') }}" class="btn btn-primary">
            + Tambah Rekening
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if ($accounts->count())
        <div class="row g-4">
            @foreach ($accounts as $account)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow h-100 border rounded-4 shadow-sm bg-light">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-semibold mb-0">
                                    <i class="bi bi-bank2 me-2 text-secondary"></i>{{ $account->name }}
                                </h5>
                            </div>

                            <p class="text-muted mb-1 mt-3">Saldo Saat Ini:</p>
                            <h4 class="text-success fw-bold">
                                Rp {{ number_format($account->balance, 0, ',', '.') }}
                            </h4>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between border-0">
                            <a href="{{ route('accounts.edit', $account->id) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            <form action="{{ route('accounts.destroy', $account->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekening ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash3"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center text-muted mt-5">
            <i class="bi bi-wallet2 fs-1 mb-3"></i>
            <p class="mb-0">Belum ada rekening yang ditambahkan.</p>
        </div>
    @endif
</div>
@endsection
