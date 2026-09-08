<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderUpdate extends Model
{
    protected $fillable = ['order_id', 'user_id', 'content', 'file_path', 'file_name', 'read_at'];

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
