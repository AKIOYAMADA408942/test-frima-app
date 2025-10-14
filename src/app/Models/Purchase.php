<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_id',
        'user_id',
        'address',
        'building',
        'payment_method',
        'postal_code',
        'purchase_status',
    ];

    public function user(){

        return $this->belongsTo(User::class);
    }

    public function item(){

        return $this->belongsTo(Item::class);
    }
    
    public function tradingChatMessages(){

        return $this->hasMany(TradingChatMessage::class);
    }

}
