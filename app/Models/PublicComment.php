<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublicComment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'comment',
        'avatar_base64',
        'is_approved',
        'is_pinned',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
            'is_pinned' => 'boolean',
        ];
    }

    /**
     * Format relative timestamp in Indonesian ("1 jam lalu", "3 hari lalu").
     */
    public function getRelativeTimeAttribute(): string
    {
        if (! $this->created_at) {
            return 'Baru saja';
        }

        return Carbon::parse($this->created_at)->locale('id')->diffForHumans();
    }
}
