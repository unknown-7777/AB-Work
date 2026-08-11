<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use SoftDeletes;

    protected $table = 'freelance_jobs';

    protected $fillable = [
        'client_id', 'category_id', 'hired_freelancer_id',
        'title', 'slug', 'description', 'required_skills',
        'budget_type', 'budget_min', 'budget_max',
        'experience_level', 'project_length',
        'status', 'deadline', 'bids_count', 'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'required_skills' => 'array',
            'deadline'        => 'datetime',
            'is_featured'     => 'boolean',
        ];
    }

    protected static function booted(): void
    {
        static::creating(function (Job $job) {
            $job->slug = Str::slug($job->title) . '-' . Str::random(5);
        });
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function hiredFreelancer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hired_freelancer_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class);
    }

    public function acceptedBid(): HasOne
    {
        return $this->hasOne(Bid::class)->where('status', 'accepted');
    }

    public function milestones(): HasMany
    {
        return $this->hasMany(Milestone::class)->orderBy('order');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function isOpen(): bool       { return $this->status === 'open'; }
    public function isInProgress(): bool { return $this->status === 'in_progress'; }
    public function isCompleted(): bool  { return $this->status === 'completed'; }

    public function hasUserBid(int $userId): bool
    {
        return $this->bids()->where('freelancer_id', $userId)->exists();
    }
}