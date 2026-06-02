<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\BelongsToTenant;

class Position extends Model
{
    use BelongsToTenant;
    
    protected $fillable = [
        'position_name'
    ];
}
