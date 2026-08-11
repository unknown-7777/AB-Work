<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'job_id', 'sender_id', 'receiver_id',
        'body', 'attachments', 'is_read', 'read_at',
    ];

    protected function casts(): array
    {
        return [
            'attachments' => 'array',
            'is_read'     => 'boolean',
            'read_at'     => 'datetime',
        ];
    }

    public function job(): BelongsTo     { return $this->belongsTo(Job::class); }
    public function sender(): BelongsTo  { return $this->belongsTo(User::class, 'sender_id'); }
    public function receiver(): BelongsTo { return $this->belongsTo(User::class, 'receiver_id'); }
}