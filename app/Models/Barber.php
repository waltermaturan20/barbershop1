<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barber extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'specialty'];

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }
}
