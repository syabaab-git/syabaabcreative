<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Service extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'service_category_id', 'thumbnail', 'title', 'slug', 'description', 'packages', 'base_price', 'estimated_days', 'is_active',
    ];
    protected $casts = [
        'packages' => 'array',
        'is_active' => 'boolean',
    ];
    public function category()
    {
        return $this->belongsTo(ServiceCategory::class, 'service_category_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }
}