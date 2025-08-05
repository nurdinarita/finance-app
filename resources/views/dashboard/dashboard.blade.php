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
                        <span class="text-success small">
                            <i class="bi bi-arrow-up"></i> 12.5% dari bulan lalu
                        </span>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-arrow-down-circle fs-1 text-success"></i>
                    </div>
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
                        <span class="text-danger small">
                            <i class="bi bi-arrow-up"></i> 8.3% dari bulan lalu
                        </span>
                    </div>
                    <div class="col-4 text-end">
                        <i class="bi bi-arrow-up-circle fs-1 text-danger"></i>
                    </div>
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
                    <div class="d-flex justify-content-between mb-2">
                        <span>Belanja</span>
                        <span class="fw-bold">Rp2,340,000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Makanan</span>
                        <span class="fw-bold">Rp1,560,000</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Transportasi</span>
                        <span class="fw-bold">Rp980,000</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Hiburan</span>
                        <span class="fw-bold">Rp870,000</span>
                    </div>
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
        <div class="transaction-item income-item">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">Gaji Bulanan</h6>
                    <small class="text-muted">05 Juni 2023</small>
                </div>
                <div class="text-success fw-bold">
                    + Rp5,500,000
                </div>
            </div>
        </div>
        
        <div class="transaction-item expense-item">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">Belanja Bulanan</h6>
                    <small class="text-muted">03 Juni 2023</small>
                </div>
                <div class="text-danger fw-bold">
                    - Rp1,250,000
                </div>
            </div>
        </div>
        
        <div class="transaction-item expense-item">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">Makan di Restoran</h6>
                    <small class="text-muted">01 Juni 2023</small>
                </div>
                <div class="text-danger fw-bold">
                    - Rp350,000
                </div>
            </div>
        </div>
        
        <div class="transaction-item income-item">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 class="mb-1">Freelance Project</h6>
                    <small class="text-muted">28 Mei 2023</small>
                </div>
                <div class="text-success fw-bold">
                    + Rp2,700,000
                </div>
            </div>
        </div>
    </div>
</div>
@endsection