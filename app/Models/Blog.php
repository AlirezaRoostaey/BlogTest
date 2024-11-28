<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'title',
        'slug',
        'content',
        'publish_at',
        'category_id',
        'user_id',
        'status',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Define a scope for filtering by archived
    public function scopeArchived($query, $archived)
    {
        if ($archived) {
            return $query->onlyTrashed();
        }
        return $query;
    }

    // Define a scope for filtering by status
    public function scopeStatus($query, $status = null)
    {
        if ($status !== null) {
            return $query->where('status', $status);
        }
        return $query;
    }

    // Define a scope for filtering by user_id
    public function scopeUserId($query, $userId = null)
    {
        if ($userId !== null) {
            return $query->where('user_id', $userId);
        }
        return $query;
    }

    // Define a scope for filtering by category_id
    public function scopeCategoryId($query, $categoryId = null)
    {
        if ($categoryId !== null) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }
}
