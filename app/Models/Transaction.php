<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model
{
    protected $fillable = [
        'payment_id', 'external_id', 'gateway_reference', 'payload', 'status',
    ];
    protected $casts = [
        'payload' => 'array',
    ];
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}