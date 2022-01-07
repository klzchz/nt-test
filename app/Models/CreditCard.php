<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'number',
        'name',
        'expirationDate'
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
