<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wallets extends Model
{
    use HasFactory;
    protected $fillable = ['users_id', 'name' , 'balance', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function revenues(): HasMany
    {
        return $this->hasMany(Revenues::class, 'wallets_id')->onDelete('cascade');
    }
    
    public function expenses(): HasMany
    {
        return $this->hasMany(Expenses::class, 'wallets_id')->onDelete('cascade');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'wallets_id')->onDelete('cascade');
    }
}

