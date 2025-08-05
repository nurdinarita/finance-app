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
        $accountsUsed = Account::where('show_in_balance', true)->get();
        $accountBalance = $accountsUsed->sum('balance');
        $totalBalance = $accountBalance;

        $income = Transaction::where('type', 'income')->get();
        $expense = Transaction::where('type', 'expense')->get();

        $totalIncome = $income->sum('amount');
        $totalExpense = $expense->sum('amount');


        $labels = ['1', '5', '10', '15', '20', '25', '30'];
        $incomeData = [];
        $expenseData = [];

        foreach ($labels as $day) {
            $nextDay = $day + 4;
            $incomeData[] = Transaction::where('type', 'income')
                ->whereDay('transaction_date', '>=', $day)
                ->whereDay('transaction_date', '<=', $nextDay)
                ->sum('amount');

            $expenseData[] = Transaction::where('type', 'expense')
                ->whereDay('transaction_date', '>=', $day)
                ->whereDay('transaction_date', '<=', $nextDay)
                ->sum('amount');
        }

        return view('dashboard.dashboard', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'categories' => Category::orderBy('name', 'asc')->get(),
            'accounts' => $accounts,
            'income' => $income,
            'expense' => $expense,
            'totalBalance' => $totalBalance,
            'totalIncome' => $totalIncome,
            'totalExpense' => $totalExpense,
            'chartLabels' => $labels,
            'chartIncomeData' => $incomeData,
            'chartExpenseData' => $expenseData,

        ]);
    }
}
