<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Portfolio extends Model
{
    protected $fillable = [
        'service_id', 'title', 'thumbnail', 'description', 'client_name', 'project_url', 'is_featured',
    ];
    protected $casts = [
        'is_featured' => 'boolean',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}