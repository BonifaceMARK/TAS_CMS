<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'contact_no', // Add contact_no field to the $fillable array
        'remarks',
        'file_attach',
    ];
}
