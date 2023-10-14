<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transactions extends Model
{
    use HasFactory;

    public function wallets(): BelongsTo
    {
        return $this->BelongsTo(Wallets::class);
    }

    public function expenses(): BelongsTo
    {
        return $this->belongsTo(Expenses::class);
    }
    
    public function revenues(): BelongsTo
    {
        return $this->belongsTo(Revenues::class);
    }
}
