<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Media extends Model
{
    protected $fillable = [
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'title',
        'description',
        'order',
    ];

    public function mediable(): MorphTo
    {
        return $this->morphTo();
    }
}
