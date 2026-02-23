<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    public function member(): HasMany
    {
        return $this->hasMany(Member::class);
    }

    protected $fillable = [
        'title',
        'resumo',
        'image_url',
        'video',
        'artigo_link',
        'artigo',
    ];

    // Indica ao Laravel que esses campos são armazenados como JSON
    protected $casts = [
        'artigo' => 'array',
    ];

}
