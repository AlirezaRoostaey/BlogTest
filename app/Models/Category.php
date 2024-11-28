<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Category extends Model
{
    use SoftDeletes, HasFactory;
    protected $fillable = [
        'title',
        'description',
        'parent_id',
    ];


    protected $hidden = ['created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::created(function () {
            Cache::forget('all_categories');
        });


        static::updated(function () {
            Cache::forget('all_categories');
        });


        static::deleted(function () {
            Cache::forget('all_categories');
        });
    }


    public function children(): HasMany
    {
        return $this->hasMany(\App\Models\Category::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()
            ->with('childrenRecursive'); // Load children recursively
    }
}
