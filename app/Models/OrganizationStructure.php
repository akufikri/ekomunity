<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationStructure extends Model
{

    protected $fillable = [
        'chart_id',
        'position_title',
        'user_id',
        'parent_id',
        'level',
        'order_index',
        'position_x',
        'position_y',
        'is_active',
        'description',
        'metadata',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'position_x' => 'decimal:2',
        'position_y' => 'decimal:2',
        'level' => 'integer',
        'order_index' => 'integer',
        'metadata' => 'array',
    ];

    /**
     * Get the organizational chart this structure belongs to
     */
    public function chart(): BelongsTo
    {
        return $this->belongsTo(OrganizationChart::class, 'chart_id');
    }

    /**
     * Get the user assigned to this position
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the parent structure
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(OrganizationStructure::class, 'parent_id');
    }

    /**
     * Get all children structures
     */
    public function children(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class, 'parent_id')->orderBy('order_index');
    }

    /**
     * Get only active children
     */
    public function activeChildren(): HasMany
    {
        return $this->children()->where('is_active', true);
    }

    /**
     * Get all descendants (children, grandchildren, etc.)
     */
    public function descendants(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class, 'parent_id')->with('descendants');
    }

    /**
     * Get all ancestors (parent, grandparent, etc.)
     */
    public function ancestors()
    {
        $ancestors = collect();
        $current = $this->parent;
        
        while ($current) {
            $ancestors->push($current);
            $current = $current->parent;
        }
        
        return $ancestors;
    }

    /**
     * Get all siblings (same parent)
     */
    public function siblings(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class, 'parent_id', 'parent_id')
                    ->where('id', '!=', $this->id);
    }

    /**
     * Scope for active structures
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for root structures (no parent)
     */
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope for specific level
     */
    public function scopeLevel($query, $level)
    {
        return $query->where('level', $level);
    }

    /**
     * Scope for specific chart
     */
    public function scopeForChart($query, $chartId)
    {
        return $query->where('chart_id', $chartId);
    }

    /**
     * Check if this structure has children
     */
    public function hasChildren(): bool
    {
        return $this->children()->exists();
    }

    /**
     * Check if this structure is a root (no parent)
     */
    public function isRoot(): bool
    {
        return is_null($this->parent_id);
    }

    /**
     * Check if this structure is a leaf (no children)
     */
    public function isLeaf(): bool
    {
        return !$this->hasChildren();
    }

    /**
     * Get the full hierarchical path
     */
    public function getPathAttribute()
    {
        $ancestors = $this->ancestors()->reverse();
        $path = $ancestors->pluck('position_title')->toArray();
        $path[] = $this->position_title;
        
        return implode(' > ', $path);
    }

    /**
     * Calculate and update the level based on parent
     */
    public function updateLevel()
    {
        if ($this->parent) {
            $this->level = $this->parent->level + 1;
        } else {
            $this->level = 0;
        }
        
        $this->save();

        // Update children levels recursively
        $this->children->each(function($child) {
            $child->updateLevel();
        });
    }

    /**
     * Get subordinates count (direct children only)
     */
    public function getSubordinatesCountAttribute()
    {
        return $this->activeChildren()->count();
    }

    /**
     * Get total descendants count (all levels)
     */
    public function getTotalSubordinatesAttribute()
    {
        return $this->getAllDescendants()->count();
    }

    /**
     * Get all descendants recursively
     */
    public function getAllDescendants()
    {
        $descendants = collect();
        
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getAllDescendants());
        }
        
        return $descendants;
    }

    /**
     * Auto-update level when parent changes
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty('parent_id')) {
                if ($model->parent) {
                    $model->level = $model->parent->level + 1;
                } else {
                    $model->level = 0;
                }
            }
        });

        static::saved(function ($model) {
            // Update children levels if this model's level changed
            if ($model->wasChanged('level')) {
                $model->children->each(function($child) {
                    $child->updateLevel();
                });
            }
        });
    }
}
