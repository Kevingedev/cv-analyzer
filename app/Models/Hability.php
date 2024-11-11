<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hability extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'description',
        'position_id',
    ];

    // Definir la relación con el modelo Position
    public function position()
    {
        return $this->belongsTo(Position::class);
    }
}
