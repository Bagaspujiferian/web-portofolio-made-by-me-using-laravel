<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand_name',
        'role_badge',
        'institution_name',
        'institution_logo_url',
        'card_header',
        'card_side_label',
        'card_footer_left',
        'card_footer_right',
        'typewriter_texts',
        'hero_bio',
        'about_bio',
        'id_card_photo_url',
        'spiderman_photo_url',
        'spotify_playlist_url',
        'spotify_embed_url',
        'background_audio_url',
        'github_url',
        'github_username',
        'instagram_url',
        'instagram_username',
        'tiktok_url',
        'tiktok_username',
        'linkedin_url',
        'email',
        'projects_count_override',
        'certificates_count_override',
        'awards_count_override',
    ];

    protected function casts(): array
    {
        return [
            'typewriter_texts' => 'array',
        ];
    }
}
