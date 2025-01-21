<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'name',
        'type',
        'description',
    ];

    public function companies()
    {
        return $this->morphedByMany(Company::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function subCompanies()
    {
        return $this->morphedByMany(SubCompany::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }

    public function branches()
    {
        return $this->morphedByMany(Branch::class, 'attributable')
            ->withPivot('value')
            ->withTimestamps();
    }
}
