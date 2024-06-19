<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    // Creando relación muchos a muchos con Clients
    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }
}
