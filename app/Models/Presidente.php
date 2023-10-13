<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presidente extends Model
{
    use HasFactory;

    protected $table = 'presidente';

    protected $primaryKey = 'idP';

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

    public function frente()
    {
        return $this->belongsTo(Frente::class, 'idFrente');
    }
}
