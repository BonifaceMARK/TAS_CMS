<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TrafficViolation;
use Illuminate\Support\Facades\Schema;

class TasFile extends Model
{
    use HasFactory;

    protected $table = 'tas_files';

    protected $fillable = [
        'case_no',
        'top',
        'driver',
        'apprehending_officer',
        'violation',
        'transaction_no',
        'date_received',
        'contact_no', 
        'plate_no',
        'remarks',
        'file_attach',
        'history',
        'status', 
        'typeofvehicle',
        'fine_fee',
        'symbols', 
    ];

    public function setofficerAttribute($value)
    {
        $this->attributes['apprehending_officer'] = strtoupper($value);
    }
    public function relatedofficer()
    {
        return $this->belongsTo(ApprehendingOfficer::class, 'apprehending_officer_id', 'id');
    }

    // Define relationship with TrafficViolation model
    public function relatedViolations()
    {
        // Assuming 'violation' is a JSON-encoded field in the TasFile table
        return $this->hasMany(TrafficViolation::class,  'code');
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
    // public function setViolationAttribute($value)
    // {
    //     $this->attributes['violation'] = strtoupper($value);
    // }

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
    public function setdriverAttribute($value)
    {
        $this->attributes['driver'] = strtoupper($value);
    }
    
    // Define mutator for 'plate_no' field
    public function setPlateNoAttribute($value)
    {
        $this->attributes['plate_no'] = strtoupper($value);
    }
    public function getHistoryAttribute($value)
    {
        return $value ? json_decode($value, true) : [];
    }
    // Define mutator for 'remarks' field
public function setRemarksAttribute($value)
{
    // Convert the array of remarks to a comma-separated string
    $this->attributes['remarks'] = implode(',', $value);
}

// Define accessor for 'remarks' field
public function getRemarksAttribute($value)
{
    // Convert the comma-separated string of remarks to an array
    return $value ? explode(',', $value) : [];
}

    public function checkCompleteness()
    {
        try {
            $fillableAttributes = $this->getFillable();
            $incompleteSymbols = [];

            foreach ($fillableAttributes as $attribute) {
                // Skip updating non-existent columns
                if (!Schema::hasColumn('tas_files', $attribute)) {
                    continue;
                }

                if ($attribute !== 'history' && empty($this->$attribute)) {
                    $incompleteSymbols[$attribute] = 'incomplete';
                }
            }

            if (empty($incompleteSymbols)) {
                $this->symbols = 'complete';
            } else {
                $this->symbols = json_encode($incompleteSymbols);
            }

            $this->save();
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error updating symbols attribute: ' . $e->getMessage());

            // You can handle the error based on your requirement
            // For example, you can throw a custom exception, return a response, or perform any other action.
            throw new \Exception('Error updating symbols attribute: ' . $e->getMessage());
        }
    }
    
   
}
