<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Member;

class Project extends Model
{
    use HasFactory;
    
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
   public function members()
    {
        return $this->belongsToMany(Member::class, 'member_project', 'project_id', 'member_id');
    }


}
