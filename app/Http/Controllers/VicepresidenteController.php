<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vicepresidente;
use App\Models\Candidato;
use App\Models\Frente;
use Illuminate\Support\Facades\DB;


class VicepresidenteController extends Controller
{
    public function index()
    {
        $vicepresidentes = DB::table('vicepresidente')
        ->join('candidatos', 'vicepresidente.idCandidato', '=', 'candidatos.idCandidato')
        ->join('frentes', 'candidatos.idFrente', '=', 'frentes.idFrente')
        ->select('vicepresidente.*', 'frentes.nombre as nombre_frente')
        ->get();
    
        //return view('presidentes.index', compact('presidentes'));

        return response()->json(['vicepresidentes' => $vicepresidentes]);
    }

    public function create()
    {

        $frentes = Frente::all();

       
        return view('vicepresidentes.ingresarVicepresidente', compact('frentes'));
    }

   
    public function store(Request $request)
    {
        // Valida los datos ingresados por el usuario
      
        try {
        // Obtiene el idFrente seleccionado en el formulario
        $idFrente = $request->input('frente_id');

        // Realiza una consulta para encontrar el idCandidato correspondiente al idFrente
        $idCandidato = Candidato::whereHas('frente', function ($query) use ($idFrente) {
            $query->where('idFrente', $idFrente);
        })->value('idCandidato');

        // Crea un nuevo vicepresidente en la tabla "vicepresidente"
        $vicepresidente = new Vicepresidente();
        $vicepresidente->nombre = $request->input('nombre');
        $vicepresidente->apellido = $request->input('apellido');
        $vicepresidente->ci = $request->input('ci');
        $vicepresidente->correo = $request->input('correo');
        $vicepresidente->libreta = $request->input('libreta');
        $vicepresidente->idCandidato = $idCandidato;
        $vicepresidente->save();

        // Redirecciona a una página de éxito o muestra un mensaje de éxito
       // return redirect()->route('vicepresidentes.index')->with('success', 'Vicepresidente creado exitosamente');
       return response()->json(['message' => 'Presidente creado exitosamente'], 201);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['message' => 'Algo salió mal al crear el presidente'], 500);
    }
    }



    public function edit($id)
{
    // Obtener información del presidente con ID dado
    $vicepresidentes = DB::table('vicepresidente')
        ->join('candidatos', 'vicepresidente.idCandidato', '=', 'candidatos.idCandidato')
        ->join('frentes', 'candidatos.idFrente', '=', 'frentes.idFrente')
        ->select('vicepresidente.*', 'frentes.nombre as nombre_frente')
        ->where('vicepresidente.idV', $id) // Filtrar por ID del presidente
        ->first();

    // Obtener la lista de todos los frentes
    $frentes = DB::table('frentes')->get();

    //return view('vicepresidentes.edit', compact('vicepresidente', 'frentes'));

   // return response()->json(['presidente' => $presidente, 'frentes' => $frentes]);
   return response()->json(['vicepresidentes' => $vicepresidentes, 'frentes' => $frentes]);



}




public function update(Request $request, $id)
{
    // Validar los datos del formulario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'apellido' => 'required|string|max:255',
        'ci' => 'required|string|max:255',
        'correo' => 'required|string|max:255',
        'libreta' => 'required|string|max:255',
        'frente_id' => 'required|exists:frente,id', // Valida que el frente seleccionado exista en la tabla frente
    ]);

    $idCandidato2 = $request->input('idCandidato');


    $idFrente = $request->input('frente_id'); // Obtiene el idFrente seleccionado en el formulario

    // Realiza una consulta para encontrar el idCandidato correspondiente al idFrente
    $idCandidato = Candidato::whereHas('frente', function ($query) use ($idFrente) {
        $query->where('id', $idFrente);
    })->value('idCandidato');

    // Actualizar el presidente en la base de datos
    $vicepresidente = Vicepresidente::findOrFail($id);
    $vicepresidente->nombre = $request->input('nombre');
    $vicepresidente->apellido = $request->input('apellido');
    $vicepresidente->ci = $request->input('ci');
    $vicepresidente->correo = $request->input('correo');
    $vicepresidente->libreta = $request->input('libreta');
    $vicepresidente->idCandidato = $idCandidato;
    $vicepresidente->save();



    /*
        $idCandidato = $request->input('idCandidato');

        DB::table('presidente')
        ->where('idP', $id)
        ->update([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'ci' => $request->input('ci'),
            'correo' => $request->input('correo'),
            'libreta' => $request->input('libreta'),
            'idCandidato' => $idCandidato, // Asegúrate de tomar el valor del campo oculto
            // Resto de tus campos y actualizaciones aquí...
        ]);
    */

    // Redireccionar a la vista de índice de presidentes con un mensaje de éxito
    return redirect()->route('vicepresidentes.index')->with('success', 'vicePresidente actualizado exitosamente');
}


public function destroy($id)
{
    // Busca el presidente por su ID
    $vicepresidente = Vicepresidente::findOrFail($id);

    // Elimina el presidente
    $vicepresidente->delete();

    // Redirecciona a la vista de índice de presidentes con un mensaje de éxito
    //return redirect()->route('vicepresidentes.index')->with('success', 'Presidente eliminado exitosamente');

    return response()->json(['message' => 'Frente elim exitosamente'], 201);

}
    // Otros métodos según tus necesidades
}
