<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['title', 'tools', 'description', 'status', 'category_id', 'thumbnail'];
    
    public function  scopePublished(Builder $query): Builder {
        return $query->where('status', 'published');
    }

    public function category(): BelongsTo 
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany 
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}
