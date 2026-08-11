<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    protected $fillable = [
        'user_id', 'title', 'bio', 'location',
        'website', 'hourly_rate', 'skills',
        'languages', 'availability',
        'total_jobs_completed', 'avg_rating',
    ];

    protected function casts(): array
    {
        return [
            'skills'    => 'array',
            'languages' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}