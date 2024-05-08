<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApprehendingOfficer extends Model
{
    protected $table = 'apprehending_officers';
    protected $fillable = ['officer','department'];
    public function tasFiles()
    {
        return $this->belongsToMany(TasFile::class, 'apprehending_officer');
    }
    public function setNameAttribute($value)
    {
        $this->attributes['officer'] = strtoupper($value);
    }
}
