<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallets_id',
        'previous_balance',
        'transaction_type',
        'amount',
        'transaction_date',
        'description'
    ];
    
    public function wallets(): BelongsTo
    {
        return $this->BelongsTo(Wallets::class);
    }
}
