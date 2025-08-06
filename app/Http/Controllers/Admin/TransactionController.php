<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Transaction;
use App\Models\Category;
use App\Models\Account;
// End of models

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['account', 'category'])
            ->when(request('search'), function ($query) {
                $query->where('note', 'like', '%' . request('search') . '%')
                    ->orWhereHas('account', fn($q) => $q->where('name', 'like', '%' . request('search') . '%'));
            })
            ->when(request('type'), fn($q) => $q->where('type', request('type')))
            ->when(request('category_id'), fn($q) => $q->where('category_id', request('category_id')))
            ->orderBy('transaction_date', 'desc')
            ->paginate(10);

        $categories = Category::orderBy('name', 'asc')->get();
        $accounts = Account::where('show_in_balance', true)->orderBy('name', 'asc')->get();

        return view('transactions.transactions', [
            'title' => 'Transactions',
            'active' => 'transactions',
            'transactions' => $transactions,
            'categories' => $categories,
            'accounts' => $accounts,
        ]);

    }

    public function store(Request $request)
    {
        // Format amount (menghapus titik, mengganti koma jadi titik)
        $request->merge([
            'amount' => str_replace(['.', ','], ['', '.'], $request->amount),
            'category' => $request->transactionType === 'transfer' ? 'Pemindahan Dana' : $request->category,
        ]);

        // Validasi input
        $request->validate([
            'account' => 'required|exists:accounts,id',
            'transactionType' => 'required|in:income,expense,transfer',
            'amount' => 'required|numeric|min:0.01',
            'category' => 'required|string|max:255',
            'transactionDate' => 'required|date_format:Y-m-d\TH:i',
            'note' => 'nullable|string|max:500',
            'account_to' => 'nullable|required_if:transactionType,transfer|exists:accounts,id|different:account',
        ]);

        $amount = floatval($request->amount);
        $transactionDate = $request->transactionDate;

        // Ambil akun asal
        $account = Account::findOrFail($request->account);

        // Cek saldo cukup untuk expense dan transfer
        if (in_array($request->transactionType, ['expense', 'transfer']) && $account->balance < $amount) {
            return redirect()->back()->withErrors(['amount' => 'Saldo tidak cukup untuk transaksi ini'])->withInput();
        }

        // Ambil/buat kategori
        $categoryName = strtolower($request->category);

        $category = Category::whereRaw('LOWER(name) = ?', [$categoryName])->first();

        if (!$category) {
            $category = Category::create([
                'name' => $request->category,
                'max_limit' => null
            ]);
        }

        // === TRANSAKSI TRANSFER ===
        if ($request->transactionType === 'transfer') {
            $targetAccount = Account::findOrFail($request->account_to);

            // Kurangi saldo akun asal
            $account->balance = max(0, $account->balance - $amount);
            $account->save();

            // Tambah saldo akun tujuan
            $targetAccount->balance += $amount;
            $targetAccount->save();

            // Simpan transaksi akun asal
            Transaction::create([
                'type' => 'transfer',
                'amount' => $amount,
                'account_id' => $account->id,
                'category_id' => $category->id,
                'transaction_date' => $transactionDate,
                'note' => $request->note ?? 'Transfer ke: ' . $targetAccount->name,
            ]);

            // Simpan transaksi akun tujuan (income)
            Transaction::create([
                'type' => 'transfer',
                'amount' => $amount,
                'account_id' => $targetAccount->id,
                'category_id' => $category->id,
                'transaction_date' => $transactionDate,
                'note' => 'Transfer dari: ' . $account->name,
            ]);

            return redirect()->back()->with('success', 'Transfer berhasil disimpan.');
        }

        // === TRANSAKSI INCOME / EXPENSE ===
        // Simpan transaksi
        Transaction::create([
            'type' => $request->transactionType,
            'amount' => $amount,
            'account_id' => $account->id,
            'category_id' => $category->id,
            'transaction_date' => $transactionDate,
            'note' => $request->note,
        ]);

        // Update saldo
        if ($request->transactionType === 'income') {
            $account->balance += $amount;
        } else {
            $account->balance = max(0, $account->balance - $amount);
        }
        $account->save();

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }


}
