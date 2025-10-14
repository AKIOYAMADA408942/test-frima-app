<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TradingChatMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'sender_id',
        'sender_role',
        'content',
        'chatting_image_path',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
