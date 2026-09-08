<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_submission_id',
        'user_id',
        'body',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submission()
    {
        return $this->belongsTo(AssignmentSubmission::class, 'assignment_submission_id');
    }
}
