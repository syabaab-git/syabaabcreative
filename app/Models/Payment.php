<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Payment extends Model
{
    protected $fillable = [
        'invoice_id', 'order_id', 'user_id', 'gateway', 'method', 'amount', 'status', 'paid_at',
    ];
    protected $casts = [
        'paid_at' => 'datetime',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }
}