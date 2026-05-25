<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialista extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'especialidad',
        'telefono',
        'foto',
    ];

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
