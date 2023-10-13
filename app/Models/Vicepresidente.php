<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vicepresidente extends Model
{
    use HasFactory;

    protected $table = 'vicepresidente';

    protected $primaryKey = 'idV';

    protected $fillable = [
        'nombre',
        'apellido',
        'ci',
        'correo',
        'libreta',
        'idCandidato',
    ];

    public function candidato()
    {
        return $this->belongsTo(Candidato::class, 'idCandidato');
    }
}
