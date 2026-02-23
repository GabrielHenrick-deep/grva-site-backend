<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'foto',
        'cell',
        'email',
        'category',
        'pesquisa',
        'lattes',
        'linkedin',
        'orcid',
        'link',
        'project_id'
    ];


    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

}
