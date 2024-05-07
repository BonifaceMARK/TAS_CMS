<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TasFile;
class fileviolation extends Model
{
    protected $table = 'traffic_violations';

    protected $fillable = ['tas_file_id','traffic_violation_id'];
    
}
