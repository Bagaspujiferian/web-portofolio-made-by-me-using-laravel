<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'thumbnail_url',
        'short_description',
        'full_description',
        'tech_stack',
        'features',
        'demo_url',
        'repo_url',
        'is_featured',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'tech_stack' => 'array',
            'features' => 'array',
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Map technology names to official colored Devicon SVGs.
     */
    public static function resolveDeviconUrl(string $name): string
    {
        $key = strtolower(trim($name));

        $map = [
            'php' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg',
            'php 8' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg',
            'php 8.2' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg',
            'php 8.3' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg',
            'laravel' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg',
            'laravel 12' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg',
            'laravel 13' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg',
            'mysql' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg',
            'html' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg',
            'html5' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg',
            'css' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg',
            'css3' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg',
            'javascript' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg',
            'js' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg',
            'tailwind' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg',
            'tailwind css' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/tailwindcss/tailwindcss-original.svg',
            'alpine.js' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/alpinejs/alpinejs-original.svg',
            'vscode' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg',
            'vs code' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg',
            'xampp' => '/images/icons/xampp.svg',
            'tabler ui' => '/images/icons/tabler.svg',
            'nodemcu esp8266' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg',
            'esp8266' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg',
            'linux' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/linux/linux-original.svg',
            'linux proxmox/armbian' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/linux/linux-original.svg',
            'proxmox' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/linux/linux-original.svg',
            'git' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg',
            'github' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/github/github-original.svg',
            'bootstrap' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/bootstrap/bootstrap-original.svg',
            'docker' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/docker/docker-original.svg',
        ];

        return $map[$key] ?? 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/devicon/devicon-original.svg';
    }

    /**
     * Always return normalized array of ['name' => string, 'icon' => string].
     */
    public function getNormalizedTechStackAttribute(): array
    {
        $items = $this->tech_stack ?? [];
        if (! is_array($items)) {
            return [];
        }

        $result = [];
        foreach ($items as $item) {
            if (is_array($item) && isset($item['name'])) {
                $result[] = [
                    'name' => $item['name'],
                    'icon' => $item['icon'] ?? self::resolveDeviconUrl($item['name']),
                ];
            } elseif (is_string($item) && trim($item) !== '') {
                $result[] = [
                    'name' => trim($item),
                    'icon' => self::resolveDeviconUrl($item),
                ];
            }
        }

        return $result;
    }
}
