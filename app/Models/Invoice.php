<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;

class Invoice extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'unique_document_identifier',
        'value',
        'issue_date',
        'sender_cnpj',
        'sender_name',
        'carrier_cnpj',
        'carrier_name',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilterByUserId($query, int $userId)
    {
        $query->where('user_id', $userId);
    }
}
