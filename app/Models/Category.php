<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'description', 'is_active'];

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}