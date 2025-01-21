<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class SubCompany extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'slug',
        'description',
        'logo_path',
        'website',
        'email',
        'phone',
        'address',
        'is_active',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }

    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }
}
