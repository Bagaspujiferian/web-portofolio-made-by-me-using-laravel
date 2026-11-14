<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certificate extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'issuer',
        'issue_date',
        'image_url',
        'credential_url',
        'type',
        'sort_order',
    ];

    public function scopeCertificates(Builder $query): Builder
    {
        return $query->where('type', 'certificate');
    }

    public function scopeAchievements(Builder $query): Builder
    {
        return $query->where('type', 'achievement');
    }
}
