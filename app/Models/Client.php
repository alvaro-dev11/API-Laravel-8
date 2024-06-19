<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Habilitar la asignación masiva de datos
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address'
    ];

    // Creando relación muchos a muchos con Services
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
}
