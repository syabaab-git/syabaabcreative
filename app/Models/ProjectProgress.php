<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProjectProgress extends Model
{
    protected $fillable = [
        'project_id', 'title', 'description', 'percentage', 'status', 'attachment',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}