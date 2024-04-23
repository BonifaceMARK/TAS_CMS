<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TasFile extends Model
{
    use HasFactory;

    protected $table = 'tas_files';

    protected $fillable = [
        'CASE_NO',
        'TOP',
        'NAME',
        'VIOLATION',
        'TRANSACTION_NO',
        'transaction_date', 
        'REMARKS',
    ];
}
