@extends('layouts.app')

@section('title', 'Dashboard')

@section('styles')
<style>
    .card {
        border-radius: 0.5rem;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        margin-bottom: 1.5rem;
        border: none;
    }
    
    .card-header {
        background-color: var(--secondary-color);
        border-bottom: 1px solid #e3e6f0;
        padding: 1rem 1.25rem;
        font-weight: 600;
    }
    
    .finance-card {
        border-left: 0.25rem solid;
        height: 100%;
    }
    
    .income-card {
        border-left-color: var(--success-color);
    }
    
    .expense-card {
        border-left-color: var(--danger-color);
    }
    
    .balance-card {
        border-left-color: var(--primary-color);
    }
    
    .chart-area {
        position: relative;
        height: 300px;
    }
</style>
@endsection

@section('main-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0">Ringkasan Keuangan</h4>
    <div class="dropdown">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Bulan Ini
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Minggu Ini</a></li>
            <li><a class="dropdown-item" href="#">Bulan Ini</a></li>
            <li><a class="dropdown-item" href="#">Tahun Ini</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Custom</a></li>
        </ul>
    </div>
</div>

<!-- Stats Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="card h-100 finance-card balance-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="text-uppercase text-muted small mb-2">Saldo</h5>
                        <h3 class="mb-0">{{ 'Rp ' . number_format($totalBalance, 0, ',', '.') }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-wallet2 fs-1 text-primary"></i>
                    </div>
                </div>
                <div class="row">
                    {{-- Rekening dalam 3 kolom --}}
                    <div class="row g-2 mt-2">
                        @foreach($usedAccounts as $account)
                            <div class="col-4">
                                <div class="p-2 rounded border bg-light h-100">
                                    <div class="text-muted small mb-1">{{ $account->name }}</div>
                                    <div class="text-dark fw-semibold small">Rp {{ number_format($account->balance, 0, ',', '.') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 finance-card income-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="text-uppercase text-muted small mb-2">Pendapatan</h5>
                        <h3 class="mb-0">{{ 'Rp ' . number_format($totalIncome, 0, ',', '.') }}</h3>
                      
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-arrow-down-circle fs-1 text-success"></i>
                    </div>
                </div>
                <div class="row mt-2">
                {{-- Tampilkan 3 transaksi pendapatan terakhir --}}
                @foreach (collect($lastTransactions)->where('type', 'income')->take(3) as $transaction)
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">{{ $transaction->category->name }}</span>
                            <span class="text-success fw-bold">
                                + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card h-100 finance-card expense-card">
            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h5 class="text-uppercase text-muted small mb-2">Pengeluaran</h5>
                        <h3 class="mb-0">{{ 'Rp ' . number_format($totalExpense, 0, ',', '.') }}</h3>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                    </div>
                </div>
                {{-- Tampilkan 3 transaksi Pengeluaran terakhir --}}
                <div class="row mt-2">
                @foreach (collect($lastTransactions)->where('type', 'expense')->take(3) as $transaction)
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted small">{{ $transaction->category->name }}</span>
                            <span class="text-danger fw-bold">
                                + Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Grafik Keuangan Bulan Ini</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="financeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Distribusi Pengeluaran</h6>
            </div>
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="expenseChart"></canvas>
                </div>
                <hr>
                <div class="mt-3">
                    @foreach($expenseCategoryLabels as $index => $label)
                        <div class="d-flex justify-content-between mb-2">
                            <span>{{ $label }}</span>
                            <span class="fw-bold">Rp{{ number_format($expenseCategoryData[$index], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Transaksi Terakhir</h6>
        <a href="#" class="btn btn-sm btn-primary">Lihat Semua</a>
    </div>
    <div class="card-body">
        @foreach($lastTransactions as $transaction)
        <div class="transaction-item {{ $transaction->type === 'income' ? 'income-item' : ($transaction->type === 'transfer' ? 'transfer-item' : 'expense-item') }}">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1 fw-semibold">{{ $transaction->account->name }} - {{ $transaction->category->name }}</h6>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d/m/Y, H:i') }}</small>
                    <small class="text-muted d-block">{{ $transaction->note }}</small>
                </div>
                <div class="{{ $transaction->type === 'income' ? 'text-success' : ($transaction->type === 'transfer' ? 'text-primary' : 'text-danger') }} fw-bold">
                    {{ $transaction->type === 'income' ? '+' : ($transaction->type === 'transfer' ? '↔' : '-') }} {{ 'Rp ' . number_format($transaction->amount, 0, ',', '.') }}
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection