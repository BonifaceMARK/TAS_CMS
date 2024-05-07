<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContestedHistory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'contested_histories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tas_files_id',
        'changes',
    ];

    /**
     * Get the TAS file associated with the contested history.
     */
    public function tasFile()
    {
        return $this->belongsTo(TasFile::class, 'tas_files_id');
    }
}
