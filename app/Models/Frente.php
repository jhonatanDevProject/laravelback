<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frente extends Model
{
    use HasFactory;

    protected $table = 'frentes';
    protected $primaryKey = 'idFrente';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function Candidato()
    {
        return $this->belongsTo(Candidato::class);
    }

    public function frente()
    {
        return $this->belongsTo(Frente::class, 'idFrente', 'idFrente');
    }

}
