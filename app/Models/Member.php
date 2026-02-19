<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

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
    ];


    public function projects()
    {
        return $this->belongsToMany(Project::class, 'member_project', 'member_id', 'project_id');
    }
     
}
