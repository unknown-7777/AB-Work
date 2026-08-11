<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $fillable = [
        'job_id', 'reviewer_id', 'reviewee_id',
        'rating', 'communication', 'quality',
        'expertise', 'professionalism', 'deadline',
        'comment', 'is_public',
    ];

    public function job(): BelongsTo      { return $this->belongsTo(Job::class); }
    public function reviewer(): BelongsTo { return $this->belongsTo(User::class, 'reviewer_id'); }
    public function reviewee(): BelongsTo { return $this->belongsTo(User::class, 'reviewee_id'); }
}