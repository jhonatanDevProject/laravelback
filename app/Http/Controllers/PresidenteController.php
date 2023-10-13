<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Presidente;
use App\Models\Candidato;
use App\Models\Frente;
use Illuminate\Support\Facades\DB;


class PresidenteController extends Controller
{
   
    public function index()
    {
        // Obtén la lista de presidentes con candidatos
        $presidentes = DB::table('presidente')
        ->join('candidatos', 'presidente.idCandidato', '=', 'candidatos.idCandidato')
        ->join('frentes', 'candidatos.idFrente', '=', 'frentes.idFrente')
        ->select('presidente.*', 'frentes.nombre as nombre_frente')
        ->get();
    
        //return view('presidentes.index', compact('presidentes'));

        return response()->json(['presidentes' => $presidentes]);
    }

   /* public function create()
    {

        $frentes = Frente::all();

       return view('presidentes.ingresarPresidente', compact('frentes'));

        //return view('presidentes.index');
    }*/


    public function create()
    {

       
        $frentes = Frente::all();
        //return view('frentes.index', compact('frentes'));

        //return response()->json(['frentes' => $frentes]);

        if ($frentes) {
            return response()->json(['frentes' => $frentes]);
        } else {
            return response()->json(['message' => 'Frente no encontrado'], 404);
        }
    
            //return Frente::select('idFrente','nombre','descripcion')->get();
        
        //$frente = Frente::all();

        //return view('presidentes.ingresarPresidente', compact('frente'));
        //return $frente;
    }

    public function store(Request $request)
    {
        // Valida los datos ingresados por el usuario
      
    
        try {
            // Obtiene el idCandidato del frente seleccionado
            $idFrente = $request->input('idCandidato');
    
            // Realiza una consulta para encontrar el idCandidato correspondiente al idFrente
            $idCandidato = Candidato::whereHas('frente', function ($query) use ($idFrente) {
                $query->where('idFrente', $idFrente);
            })->value('idCandidato');
    
            // Crea un nuevo presidente en la tabla "presidente"
            $presidente = new Presidente();
            $presidente->nombre = $request->input('nombre');
            $presidente->apellido = $request->input('apellido');
            $presidente->ci = $request->input('ci');
            $presidente->correo = $request->input('correo');
            $presidente->libreta = $request->input('libreta');
            $presidente->idCandidato = $idCandidato;
            $presidente->save();
    
            return response()->json(['message' => 'Presidente creado exitosamente'], 201);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Algo salió mal al crear el presidente'], 500);
        }
    }

 


public function edit($id)
{
    
    // Obtener información del presidente con ID dado
    $presidentes = DB::table('presidente')
        ->join('candidatos', 'presidente.idCandidato', '=', 'candidatos.idCandidato')
        ->join('frentes', 'candidatos.idFrente', '=', 'frentes.idFrente')
        ->select('presidente.*', 'frentes.nombre as nombre_frente')
        ->where('presidente.idP', $id) // Filtrar por ID del presidente
        ->first();

    // Obtener la lista de todos los frentes
    $frentes = DB::table('frentes')->get();

    // Verificar si se encontró el presidente
    if ($presidentes) {
        return response()->json(['presidentes' => $presidentes, 'frentes' => $frentes]);
    } else {
        return response()->json(['message' => 'Presidente no encontrado'], 404);
    }


   
}



public function update(Request $request, $id)
{
    
       try {
        // Busca el frente por su ID
        //$frente = Pre::findOrFail($id);

        // Actualiza los datos del frente
        $presidente = Presidente::findOrFail($id);
        $presidente->nombre = $request->input('nombre');
        $presidente->apellido = $request->input('apellido');
        $presidente->ci = $request->input('ci');
        $presidente->correo = $request->input('correo');
        $presidente->libreta = $request->input('libreta');
        $presidente->idCandidato = $request->input('idFrente'); // Cambia a 'frente_id'
        $presidente->save();

        return response()->json(['message' => 'Frente actualizado exitosamente'], 200);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        return response()->json(['message' => 'Algo salió mal al actualizar el frente'], 500);
    }
    
}

public function destroy($id)
{
    // Busca el presidente por su ID
    $presidente = Presidente::findOrFail($id);

    // Elimina el presidente
    $presidente->delete();

    // Redirecciona a la vista de índice de presidentes con un mensaje de éxito
   // return redirect()->route('presidentes.index')->with('success', 'Presidente eliminado exitosamente');
   return response()->json(['message' => 'pres creado exitosamente'], 201);

}

    // Otros métodos según tus necesidades
}
