<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order',
        'total',
        'trade_no'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function getSumAttribute()
    {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += ($item->price * $item->pivot->qty);
        }
        return $sum;
    }
}
