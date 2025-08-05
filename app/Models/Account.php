<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    // public function scopeVisible($query)
    // {
    //     return $query->where('show_in_balance', true);
    // }
}
