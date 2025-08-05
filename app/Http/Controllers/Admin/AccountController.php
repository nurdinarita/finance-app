<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Account;
use App\Models\Category;
// End of models

class AccountController extends Controller
{
    public function index()
    {
        $accounts = Account::all();
        $categories = Category::orderBy('name', 'asc')->get();

        return view('accounts.accounts', [
            'title' => 'Accounts',
            'active' => 'accounts',
            'accounts' => $accounts,
            'categories' => $categories,
        ]);
    }
}
