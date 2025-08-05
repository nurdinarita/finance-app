<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Transaction;
use App\Models\Category;
// End of models

class TransactionController extends Controller
{
    public function index()
    {
        return view('admin.transactions.index');
    }

    public function store(Request $request)
    {
        // Format amount
        $request->merge([
            'amount' => str_replace(['.', ','], ['', '.'], $request->amount)
        ]);

        // Validasi input
        $request->validate([
            'account' => 'required|exists:accounts,id',
            'transactionType' => 'required|in:income,expense',
            'amount' => 'required|numeric|min:0',
            'category' => 'required|string|max:255', // string karena bisa input baru
            'transactionDate' => 'required|date_format:Y-m-d\TH:i',
            'note' => 'nullable|string|max:500',
        ]);

        // Cari kategori, kalau tidak ada, buat baru
        $category = Category::firstOrCreate(
            ['name' => $request->category],
            ['max_limit' => null]
        );

        // Simpan transaksi
        Transaction::create([
            'type' => $request->transactionType,
            'amount' => $request->amount,
            'account_id' => $request->account,
            'category_id' => $category->id,
            'transaction_date' => $request->transactionDate,
            'note' => $request->note,
        ]);

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan');
    }

}
