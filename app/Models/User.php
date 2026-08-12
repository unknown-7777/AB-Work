<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'is_active'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'is_active'         => 'boolean',
        ];
    }

    public function isClient(): bool     { return $this->role === 'client'; }
    public function isFreelancer(): bool { return $this->role === 'freelancer'; }
    public function isAdmin(): bool      { return $this->role === 'admin'; }

    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function postedJobs(): HasMany
    {
        return $this->hasMany(Job::class, 'client_id');
    }

    public function bids(): HasMany
    {
        return $this->hasMany(Bid::class, 'freelancer_id');
    }

    public function reviewsReceived(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewee_id');
    }

    public function reviewsGiven(): HasMany
    {
        return $this->hasMany(Review::class, 'reviewer_id');
    }
}