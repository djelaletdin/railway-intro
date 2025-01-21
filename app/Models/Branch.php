<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Branch extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'sub_company_id',
        'name',
        'slug',
        'description',
        'manager_name',
        'email',
        'phone',
        'address',
        'latitude',
        'longitude',
        'is_active',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function subCompany(): BelongsTo
    {
        return $this->belongsTo(SubCompany::class);
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
