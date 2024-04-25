<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrafficViolation;
class TasFile extends Model
{
    use HasFactory;

    protected $table = 'tas_files';

    protected $fillable = [
        'case_no',
        'top',
        'name',
        'violation',
        'transaction_no',
        'transaction_date',
        'contact_no', 
        'plate_no',
        'remarks',
        'file_attach',
    ];
    public function trafficViolations()
    {
        return $this->hasMany(TrafficViolation::class, 'violation');
    }
    public function setTopAttribute($value)
    {
        $this->attributes['top'] = strtoupper($value);
    }

    // Define mutator for 'name' field
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtoupper($value);
    }

    // Define mutator for 'violation' field
    public function setViolationAttribute($value)
    {
        $this->attributes['violation'] = strtoupper($value);
    }

    // Define mutator for 'transaction_no' field
    public function setTransactionNoAttribute($value)
    {
        $this->attributes['transaction_no'] = strtoupper($value);
    }

    // Define mutator for 'contact_no' field
    public function setContactNoAttribute($value)
    {
        $this->attributes['contact_no'] = strtoupper($value);
    }

    // Define mutator for 'plate_no' field
    public function setPlateNoAttribute($value)
    {
        $this->attributes['plate_no'] = strtoupper($value);
    }
    
}
