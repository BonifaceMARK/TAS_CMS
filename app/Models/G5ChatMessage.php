<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class G5ChatMessage extends Model
{
    use HasFactory;

    protected $table = 'chat_messages'; // Specify the table name

    protected $fillable = [
        'user_id',
        'message',
        'is_read', // Include the is_read column in the fillable array
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
