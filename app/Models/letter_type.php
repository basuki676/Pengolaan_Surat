<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class letter_type extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    // Contoh pada model LetterType
    public function letters()
    {
        return $this->hasMany(Letter::class, 'letter_type_id', 'letter_code');
    }
    
}
