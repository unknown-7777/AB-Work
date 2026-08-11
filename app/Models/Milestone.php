<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Milestone extends Model
{
    protected $fillable = [
        'job_id', 'bid_id', 'title', 'description',
        'amount', 'due_date', 'order', 'status',
        'payment_released', 'payment_released_at',
        'submission_note', 'revision_note',
    ];

    protected function casts(): array
    {
        return [
            'due_date'            => 'datetime',
            'payment_released'    => 'boolean',
            'payment_released_at' => 'datetime',
        ];
    }

    public function job(): BelongsTo { return $this->belongsTo(Job::class); }
    public function bid(): BelongsTo { return $this->belongsTo(Bid::class); }

    public function isApproved(): bool { return $this->status === 'approved'; }
    public function isSubmitted(): bool { return $this->status === 'submitted'; }
}