<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FinanceTrack - Aplikasi Keuangan Pribadi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- CSS Tom Select -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <!-- JS Tom Select -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>


    

    
    @yield('styles')

    <style>
        :root {
            --primary-color: #4e73df;
            --secondary-color: #f8f9fc;
            --success-color: #1cc88a;
            --danger-color: #e74a3b;
            --warning-color: #f6c23e;
            --info-color: #36b9cc;
            --dark-color: #5a5c69;
            --hover-color: #6e84ffff;
            --hover-text-color: #ffffff;
            --active-bg-color: #6e84ffff;
            --active-text-color: #ffffffff;
        }
    
        .sidebar {
            min-height: 100vh;
            background-color: var(--secondary-color);
            transition: all 0.3s;
        }

        /* Sidebar nav-link */
        .sidebar .nav-link {
            color: #5a5c69;
            padding: 10px 20px;
            border-radius: 0.375rem;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        /* Hover effect sidebar */
        .sidebar .nav-link:hover {
            background-color: var(--hover-color);
            color: var(--hover-text-color);
        }

        /* Active sidebar menu */
        .sidebar .nav-link.active {
            background-color: var(--active-bg-color);
            color: var(--active-text-color);
            font-weight: 600;
        }

        
        
 
        
        .mobile-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 -5px 10px rgba(0,0,0,0.1);
            display: none;
            z-index: 1000;
        }
        .mobile-nav a {
            transition: color 0.3s ease;
        }

        .mobile-nav a.active {
            color: var(--primary-color) !important;
        }

        .mobile-nav a:hover {
            color: var(--primary-color);
        }

        
        .navbar-brand img {
            height: 40px;
        }
        
        .add-btn {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            font-size: 24px;
            z-index: 1000;
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }
        
        @media (max-width: 991.98px) {
            .mobile-nav {
                display: flex;
            }
            
            .desktop-nav {
                display: none !important;
            }
            
            .sidebar {
                min-height: auto;
            }
            
            body {
                padding-top: 56px; /* Already set in base body style */
            }

            .navbar-brand img {
                height: 32px;
            }
        }
        
        .transaction-item {
            border-left: 3px solid;
            padding-left: 10px;
            margin-bottom: 10px;
        }
        
        .income-item {
            border-left-color: var(--success-color);
        }
        
        .expense-item {
            border-left-color: var(--danger-color);
        }
        
        .logo-text {
            font-weight: 800;
            letter-spacing: -1px;
        }
    </style>
</head>
<body>
    <!-- Desktop Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary desktop-nav sticky-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="logo-text text-white me-1">FinanceTrack</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house-door me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-wallet2 me-1"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-pie-chart me-1"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear me-1"></i> Pengaturan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Header -->
    <nav class="navbar navbar-dark bg-primary d-lg-none fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <span class="logo-text text-white me-1">FinanceTrack</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mobileNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="mobileNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="#"><i class="bi bi-house-door me-1"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-wallet2 me-1"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-pie-chart me-1"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear me-1"></i> Pengaturan</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Mobile Bottom Navigation -->
    <div class="mobile-nav py-2 px-3 d-md-none">
        <div class="w-100 d-flex justify-content-between align-items-center">
            <a href="{{ route('dashboard') }}" class="text-center text-dark text-decoration-none {{ $active === 'dashboard' ? 'active' : '' }}">
                <i class="bi bi-house-door fs-5 d-block"></i>
                <span class="small">Dashboard</span>
            </a>
            <a href="#" class="text-center text-dark text-decoration-none">
                <i class="bi bi-wallet2 fs-5 d-block"></i>
                <span class="small">Transaksi</span>
            </a>
            <a href="{{ route('accounts') }}" class="text-center text-dark text-decoration-none {{ $active === 'accounts' ? 'active' : '' }}">
                <i class="bi bi-bank fs-5 d-block"></i>
                <span class="small">Rekening</span>
            </a>
            <a href="#" class="text-center text-dark text-decoration-none">
                <i class="bi bi-pie-chart fs-5 d-block"></i>
                <span class="small">Laporan</span>
            </a>
            <a href="#" class="text-center text-dark text-decoration-none">
                <i class="bi bi-gear fs-5 d-block"></i>
                <span class="small">Pengaturan</span>
            </a>
        </div>
    </div>
    
    <!-- Main Content -->
    <div class="container-fluid mt-4 mb-5 mb-lg-0">
        <div class="row">
            <!-- Desktop Sidebar -->
            <div class="col-lg-2 d-none d-lg-block sidebar">
                <div class="text-center py-4">
                    <img src="https://storage.googleapis.com/workspace-0f70711f-8b4e-4d94-86f1-2a93ccde5887/image/472bb3e1-c3af-488e-905d-981e1a8e1572.png" alt="Circular user profile picture with white background showing a professional headshot of a smiling person wearing business casual attire" class="rounded-circle mb-2" width="80">
                    <h5 class="mb-1">John Doe</h5>
                    <small class="text-muted">john@example.com</small>
                </div>
                
                <hr class="my-3">
                
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}"><i class="bi bi-grid me-2"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-wallet2 me-2"></i> Transaksi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $active === 'accounts' ? 'active' : '' }}" href="{{ route('accounts') }}"><i class="bi bi-bank me-2"></i> Rekening</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-pie-chart me-2"></i> Laporan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-tags me-2"></i> Kategori</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="bi bi-gear me-2"></i> Pengaturan</a>
                    </li>
                </ul>
            </div>
            
            <!-- Main Content Area -->
            <div class="col-lg-10 col-12 mb-5 mb-lg-0">

                @yield('main-content')

            </div>
        </div>
    </div>
    
    <!-- Floating Add Button -->
    <button class="btn btn-primary add-btn" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
        <i class="bi bi-plus-lg"></i>
    </button>
    
    <!-- Add Transaction Modal -->
    <div class="modal fade" id="addTransactionModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Jenis Transaksi -->
                    <div class="mb-3">
                        <label class="form-label">Jenis Transaksi</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="transactionType" id="income" value="income" autocomplete="off" required>
                            <label class="btn btn-outline-success" for="income">Pendapatan</label>

                            <input type="radio" class="btn-check" name="transactionType" id="expense" value="expense" autocomplete="off" required>
                            <label class="btn btn-outline-danger" for="expense">Pengeluaran</label>

                            <input type="radio" class="btn-check" name="transactionType" id="transfer" value="transfer" autocomplete="off" required>
                            <label class="btn btn-outline-primary" for="transfer">Pindah Dana</label>
                        </div>
                    </div>

                    <!-- Rekening -->
                    <div class="mb-3" id="accountFromGroup">
                        <label class="form-label" id="accountFromLabel">Rekening</label>
                        <select name="account" id="accountFrom" class="form-select" required>
                            <option value="">Pilih Rekening</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Rekening Tujuan (hanya untuk transfer) -->
                    <div class="mb-3 d-none" id="accountToGroup">
                        <label class="form-label">Ke Rekening</label>
                        <select name="account_to" class="form-select">
                            <option value="">Pilih Rekening Tujuan</option>
                            @foreach($accounts as $account)
                                <option value="{{ $account->id }}">{{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Jumlah -->
                    <div class="mb-3">
                        <label class="form-label">Jumlah</label>
                        <div class="input-group">
                            <span class="input-group-text">Rp</span>
                            <input type="text" name="amount" class="form-control" placeholder="0" id="amountInput" autocomplete="off" required>
                        </div>
                    </div>

                    <!-- Kategori (kecuali untuk transfer) -->
                    <div class="mb-3" id="categoryGroup">
                        <label class="form-label">Kategori</label>
                        <select id="kategoriSelect" class="form-select" name="category">
                            <option value="">Pilih kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->name }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tanggal -->
                    <div class="mb-3">
                        <label class="form-label">Tanggal</label>
                        <input type="datetime-local" class="form-control" name="transactionDate" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                    </div>

                    <!-- Catatan -->
                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea class="form-control" rows="2" placeholder="Tambahkan catatan (opsional)" name="note"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const income = document.getElementById('income');
            const expense = document.getElementById('expense');
            const transfer = document.getElementById('transfer');

            const accountFromLabel = document.getElementById('accountFromLabel');
            const accountFrom = document.getElementById('accountFrom');
            const accountToGroup = document.getElementById('accountToGroup');
            const categoryGroup = document.getElementById('categoryGroup');

            function updateForm() {
                if (transfer.checked) {
                    accountToGroup.classList.remove('d-none');
                    accountFromLabel.innerText = 'Dari Rekening';
                    accountFrom.setAttribute('name', 'account');
                    categoryGroup.classList.add('d-none');
                } else {
                    accountToGroup.classList.add('d-none');
                    accountFromLabel.innerText = 'Rekening';
                    accountFrom.setAttribute('name', 'account');
                    categoryGroup.classList.remove('d-none');
                }
            }

            [income, expense, transfer].forEach(el => {
                el.addEventListener('change', updateForm);
            });
        });
    </script>


    <script>
        new TomSelect("#kategoriSelect", {
            create: true, // agar bisa tambah kategori baru
            sortField: {
                field: "text",
                direction: "asc"
            },
            placeholder: "Pilih atau tambah kategori"
        });
    </script>


    <script>
        const amountInput = document.getElementById('amountInput');

        amountInput.addEventListener('input', function (e) {
            // Hapus semua karakter selain angka
            let value = e.target.value.replace(/\D/g, '');

            // Format ribuan pakai titik
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });
    </script>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
    @if($active === 'dashboard')
        <script>
            // Initialize charts
            document.addEventListener('DOMContentLoaded', function() {
                // Financial Chart
                const financeCtx = document.getElementById('financeChart').getContext('2d');
                const financeChart = new Chart(financeCtx, {
                    type: 'bar',
                    data: {
                                labels: @json($chartLabels),
                                datasets: [
                                    {
                                        label: 'Pendapatan',
                                        backgroundColor: '#1cc88a',
                                        borderColor: '#1cc88a',
                                        data: @json($chartIncomeData),
                                    },
                                    {
                                        label: 'Pengeluaran',
                                        backgroundColor: '#e74a3b',
                                        borderColor: '#e74a3b',
                                        data: @json($chartExpenseData),
                                    }
                                ]
                            },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    callback: function(value) {
                                        return 'Rp' + value.toLocaleString();
                                    }
                                }
                            }
                        }
                    }
                });
                
                // Expense Chart
                const expenseCtx = document.getElementById('expenseChart').getContext('2d');
                const expenseChart = new Chart(expenseCtx, {
                    type: 'doughnut',
                    data: {
                        labels: {!! json_encode($expenseCategoryLabels) !!},
                        datasets: [{
                            data: {!! json_encode($expenseCategoryData) !!},
                            backgroundColor: ['#4e73df', '#1cc88a', '#ffc107', '#e74a3b', '#858796'],
                            hoverBackgroundColor: ['#2e59d9', '#17a673', '#dda20a', '#be2617', '#666872'],
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'right',
                            },
                        },
                    },
                });
            });
        </script>
    @endif
</body>
</html>