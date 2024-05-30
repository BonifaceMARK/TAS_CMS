<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TasFile;
use App\Models\admitted;
class TrafficViolation extends Model
{
    use HasFactory;
    protected $table = 'traffic_violations';

    protected $fillable = ['id','code','violation'];
    
    public function tasFiles()
    {
        return $this->belongsToMany(TasFile::class, 'id');
    }
    public function admittedFiles()
    {
        return $this->belongsToMany(admitted::class, 'id');
    }
    public function setviolationAttribute($value)
    {
        $this->attributes['violation'] = strtoupper($value);
    }
}
