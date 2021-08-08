<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];

    public function items()
    {
        return $this->belongsToMany(Item::class)->withTimestamps()->withPivot('qty');
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
