<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrganizationChart extends Model
{

    protected $fillable = [
        'chart_name',
        'chart_type',
        'description',
        'company_id',
        'created_by',
        'is_active',
        'is_published',
        'effective_date',
        'end_date',
        'chart_settings',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_published' => 'boolean',
        'effective_date' => 'date',
        'end_date' => 'date',
        'chart_settings' => 'array',
    ];

    /**
     * Get all organizational structures for this chart
     */
    public function structures(): HasMany
    {
        return $this->hasMany(OrganizationStructure::class, 'chart_id');
    }

    /**
     * Get only active structures
     */
    public function activeStructures(): HasMany
    {
        return $this->structures()->where('is_active', true);
    }

    /**
     * Get root structures (top-level positions)
     */
    public function rootStructures(): HasMany
    {
        return $this->structures()->whereNull('parent_id')->orderBy('order_index');
    }

    /**
     * Get the user who created this chart
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get company if company_id is set (uncomment if you have Company model)
     */
    // public function company(): BelongsTo
    // {
    //     return $this->belongsTo(Company::class, 'company_id');
    // }

    /**
     * Scope for active charts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for published charts
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope for effective charts (within date range)
     */
    public function scopeEffective($query, $date = null)
    {
        $date = $date ?? now();
        
        return $query->where('effective_date', '<=', $date)
                    ->where(function($q) use ($date) {
                        $q->whereNull('end_date')
                          ->orWhere('end_date', '>=', $date);
                    });
    }

    /**
     * Get hierarchical tree structure for this chart
     */
    public function getHierarchicalStructure()
    {
        $structures = $this->activeStructures()
                          ->with('user', 'children.user')
                          ->get();

        return $this->buildTree($structures);
    }

    /**
     * Build hierarchical tree from flat collection
     */
    private function buildTree($structures, $parentId = null)
    {
        $tree = collect();
        
        foreach ($structures->where('parent_id', $parentId) as $structure) {
            $structure->children = $this->buildTree($structures, $structure->id);
            $tree->push($structure);
        }
        
        return $tree->sortBy('order_index');
    }
}
