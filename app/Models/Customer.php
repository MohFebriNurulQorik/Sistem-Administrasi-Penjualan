<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;



class Customer extends Model
{
   use BelongsToTenant; 
   
   protected $fillable = [
        'company_name',
        'email',
        'phone',
        'address',
        'attn',
        'job',
    ]; 
}
