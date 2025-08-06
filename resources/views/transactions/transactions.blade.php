@extends('layouts.app')
@section('title', 'Transaksi')

@section('main-content')
<div class="container-fluid">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Semua Transaksi</h4>
        <a href="{{ route('transactions.create') }}" class="btn btn-success btn-sm">
            <i class="fas fa-plus me-1"></i> Tambah Transaksi
        </a>
    </div>

    <!-- Search & Filter -->
    <form method="GET" action="{{ route('transactions') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Cari catatan atau akun..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="type" class="form-select">
                    <option value="">Semua Tipe</option>
                    <option value="income" {{ request('type') == 'income' ? 'selected' : '' }}>Pemasukan</option>
                    <option value="expense" {{ request('type') == 'expense' ? 'selected' : '' }}>Pengeluaran</option>
                    <option value="transfer" {{ request('type') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-filter me-1"></i> Filter
                </button>
            </div>
        </div>
    </form>

    <!-- Transaction List -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            @forelse($transactions as $transaction)
                <div class="p-3 border-bottom transaction-item
                    {{ $transaction->type === 'income' ? 'income-item' : ($transaction->type === 'transfer' ? 'transfer-item' : 'expense-item') }}
                    d-flex justify-content-between align-items-center 
                    {{ $loop->even ? 'bg-light' : '' }}">
                    <div>
                        <h6 class="mb-1 fw-semibold">{{ $transaction->account->name }} - {{ $transaction->category->name }}</h6>
                        <small class="text-muted">
                            @if (\Carbon\Carbon::parse($transaction->transaction_date)->isToday())
                                Hari ini, {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('H:i') }}
                            @else
                                {{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y, H:i') }}
                            @endif
                        </small>
                        <br>
                        <small class="text-muted">{{ $transaction->note }}</small>
                    </div>
                    <div class="text-end">
                        <span class="fw-bold 
                            {{ $transaction->type === 'income' ? 'text-success' : ($transaction->type === 'transfer' ? 'text-warning' : 'text-danger') }}">
                            {{ $transaction->type === 'income' ? '+' : ($transaction->type === 'transfer' ? '↔' : '-') }}
                            Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </span>
                        <br>
                        <span class="badge bg-{{ $transaction->type === 'income' ? 'success' : ($transaction->type === 'transfer' ? 'warning text-dark' : 'danger') }}">
                            {{ ucfirst($transaction->type) }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="p-4 text-center text-muted">
                    Tidak ada transaksi ditemukan.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $transactions->withQueryString()->links() }}
    </div>
</div>
@endsection
