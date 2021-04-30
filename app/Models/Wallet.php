<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = "wallet";
    protected $primaryKey = "id";

    protected $fillable = [
        'user_id', 'amount'
    ];
}
