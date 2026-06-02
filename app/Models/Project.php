<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class Project extends Model
{
    use BelongsToTenant; 
    protected $fillable = [
        'code',
        'name'
    ];
}
