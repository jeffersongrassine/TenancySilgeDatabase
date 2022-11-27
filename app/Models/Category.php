<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsTenantScope;

class Category extends Model
{
    use HasFactory, BelongsTenantScope;

    protected $fillable = [
        'name',
        'description'
    ];

    // generate slug
    public function setNameAttribute($prop)
    {
        $this->attributes['name'] = $prop;
        $this->attributes['slug'] = \Illuminate\Support\Str::slug($prop);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
