<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Project extends Model
{
    protected $fillable = [
        'order_id', 'staff_id', 'title', 'status', 'progress', 'deadline',
    ];
    protected $casts = [
        'deadline' => 'date',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
    public function progresses()
    {
        return $this->hasMany(ProjectProgress::class);
    }
}