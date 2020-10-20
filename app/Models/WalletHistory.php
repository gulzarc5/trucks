<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletHistory extends Model
{
    protected $table = "wallet_history";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id', 'wallet_id', 'amount','type','total'
    ];
}
