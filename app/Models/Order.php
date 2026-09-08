<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'service_id', 'customer_name', 'email', 'whatsapp', 'package_name', 'requirement', 'amount', 'status', 'estimation_date', 'notes', 'customer_email', 'customer_phone', 'receipt_sent_at', 'receipt_file'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
    public function files()
    {
        return $this->hasMany(OrderFile::class);
    }
    public function project()
    {
        return $this->hasOne(Project::class);
    }
    public function updates()
    {
        return $this->hasMany(OrderUpdate::class)->latest();
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}