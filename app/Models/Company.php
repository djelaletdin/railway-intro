<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Company extends Model
{
    use SoftDeletes;

    protected $fillable = [
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

    public function subCompanies(): HasMany
    {
        return $this->hasMany(SubCompany::class);
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
