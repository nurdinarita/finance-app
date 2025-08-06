<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Account;
use App\Models\Category;
use App\Models\Transaction;
// End of models

class DashboardController extends Controller
{
    public function index()
    {
        $accounts = Account::orderBy('name', 'asc')->get();
        $usedAccounts = Account::where('show_in_balance', true)->get();
        $accountBalance = $usedAccounts->sum('balance');
        $totalBalance = $accountBalance;

        // Save Accounts
        $savedAccounts = Account::where('show_in_balance', false)->get();

        $income = Transaction::where('type', 'income')->whereMonth('transaction_date', date('m'))->whereYear('transaction_date', date('Y'))->get();
        $expense = Transaction::where('type', 'expense')->whereMonth('transaction_date', date('m'))->whereYear('transaction_date', date('Y'))->get();

        $totalIncome = $income->sum('amount');
        $totalExpense = $expense->sum('amount');

        $lastTransactions = Transaction::where('type', '!=', 'transfer')
            ->whereMonth('transaction_date', date('m'))
            ->whereYear('transaction_date', date('Y'))
            ->orderBy('transaction_date', 'desc')->get();


        // Labels for the chart
        // Total pengeluaran berdasarkan hari
        $labels = ['1', '5', '10', '15', '20', '25', '30'];
        $incomeData = [];
        $expenseData = [];

        foreach ($labels as $day) {
            $nextDay = $day + 4;
            $incomeData[] = Transaction::where('type', 'income')
                ->whereMonth('transaction_date', date('m'))
                ->whereYear('transaction_date', date('Y'))
                ->whereDay('transaction_date', '>=', $day)
                ->whereDay('transaction_date', '<=', $nextDay)
                ->sum('amount');

            $expenseData[] = Transaction::where('type', 'expense')
                ->whereMonth('transaction_date', date('m'))
                ->whereYear('transaction_date', date('Y'))
                ->whereDay('transaction_date', '>=', $day)
                ->whereDay('transaction_date', '<=', $nextDay)
                ->sum('amount');
        }

        // Label for the chart
        // Total pengeluaran berdasarkan kategori
        $expenseByCategory = Transaction::selectRaw('categories.name as category_name, SUM(amount) as total')
            ->join('categories', 'transactions.category_id', '=', 'categories.id')
            ->where('transactions.type', 'expense')
            ->whereMonth('transactions.transaction_date', date('m'))
            ->whereYear('transactions.transaction_date', date('Y'))
            ->groupBy('categories.name')
            ->orderBy('total', 'desc')
            ->get();

        $expenseCategoryLabels = $expenseByCategory->pluck('category_name');
        $expenseCategoryData = $expenseByCategory->pluck('total');


        return view('dashboard.dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'categories' => Category::orderBy('name', 'asc')->get(),
            'usedAccounts' => $usedAccounts,
            'savedAccounts' => $savedAccounts,
            'accounts' => $accounts,
            'income' => $income,
            'expense' => $expense,
            'totalBalance' => $totalBalance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'chartLabels' => $labels,
            'chartIncomeData' => $incomeData,
            'chartExpenseData' => $expenseData,

            'expenseCategoryLabels' => $expenseCategoryLabels,
            'expenseCategoryData' => $expenseCategoryData,
            'lastTransactions' => $lastTransactions,


        ]);
    }
}
