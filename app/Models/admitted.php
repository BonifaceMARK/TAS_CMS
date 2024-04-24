<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class admitted extends Model
{
    use HasFactory;

    protected $table = 'admitted_files';

    protected $fillable = [
        'top',
        'name',
        'violation',
        'transaction_no',
        'transaction_date',
        'contact_no', 
        'remarks',
        'file_attach',
    ];
}
