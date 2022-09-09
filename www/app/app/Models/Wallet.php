<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'currency_name', 'user_id', 'balance',
    ];

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}