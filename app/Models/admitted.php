<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admitted extends Model
{

    protected $table = 'admitteds';

    protected $fillable = [
        'resolution_no',
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
    public function relatedOfficer()
{
    return $this->hasOne(ApprehendingOfficer::class, 'officer');
}
    public function relatedViolations()
    {
        // Assuming 'violation' is a JSON-encoded field in the TasFile table
        return $this->hasMany(TrafficViolation::class, 'code');
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
    public function setViolationAttribute($value)
    {
        if (is_array($value)) {
            // Convert the array of violations to a comma-separated string
            $this->attributes['violation'] = implode(',', $value);
        } else {
            // If it's already a string, simply assign it
            $this->attributes['violation'] = $value;
        }
    }

    public function getViolationAttribute($value)
    {
        // Check if the value is already a string, then return it
        if (is_string($value)) {
            return $value;
        }
        
        // If it's an array, convert it to a string
        return $value ? implode(',', $value) : '';
    }
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
      // Method to add a new violation
      public function addViolation($newViolation)
      {
          // Retrieve existing violations
          $violations = $this->violation ?? [];
  
          // Add the new violation
          $violations[] = $newViolation;
  
          // Update the violation attribute
          $this->violation = $violations;
  
          // Save the model
          $this->save();
      }
}
