<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'parent_id',
    ];


    protected $hidden = ['created_at', 'updated_at'];


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
