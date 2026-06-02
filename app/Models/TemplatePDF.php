<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToTenant;

class TemplatePDF extends Model
{
    use BelongsToTenant; 
    protected $table = 'template_pdfs';
    protected $fillable = ['code', 'company_name', 'status','blade_name'];
}
