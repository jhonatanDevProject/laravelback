<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frente;
use App\Models\Candidato;

class FrenteController extends Controller
{

    
    public function index()
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
    }

    public function create()
    {
        return view('frentes.ingresarFrente');
    }



public function store(Request $request)
{
    // Valida los datos ingresados por el usuario
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
    ]);

    try {
        // Crea un nuevo frente en la tabla "frente"
        $frente = new Frente();
        $frente->nombre = $request->input('nombre');
        $frente->descripcion = $request->input('descripcion');
        $frente->save();

        // Crea un nuevo candidato en la tabla "candidatos" asociado al frente
        $candidato = new Candidato();
        $candidato->habilitado = true; // Opcional: Establece el candidato como habilitado
        $candidato->idFrente = $frente->idFrente; // Asigna el id del frente recién creado
        $candidato->save();

        return response()->json(['message' => 'Frente creado exitosamente'], 201);
    } catch (\Exception $e) {
        \Log::error($e->getMessage());
        //return response()->json(['error' => $e->getMessage()], 500);
        return response()->json(['message' => 'Algo salió mal al crear el frente'], 500);
    }
}


  /*  public function store(Request $request)
    {

         // Valida los datos ingresados por el usuario
         $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        // Crea un nuevo frente en la tabla "frente"
        $frente = new Frente();
        $frente->nombre = $request->input('nombre');
        $frente->descripcion = $request->input('descripcion');
        $frente->save();

        // Crea un nuevo candidato en la tabla "candidatos" asociado al frente
        $candidato = new Candidato();
        $candidato->habilitado = true; // Opcional: Establece el candidato como habilitado
        $candidato->idFrente = $frente->id; // Asigna el id del frente recién creado
        $candidato->save();

        // Aquí no realizamos ninguna operación en la base de datos, simplemente devolvemos un mensaje
        return response()->json(['message' => 'Conexión exitosa a Laravel'], 200);
    }
    */

    public function edit($id)
    {
       // $frente = Frente::findOrFail($id);
       // return view('frentes.edit', compact('frente'));

          // Realiza una consulta para obtener el frente con el ID especificado
        /*$frente = Frente::select('id', 'nombre', 'descripcion')
        ->where('id', $id)
        ->firstOrFail();

        //return view('frentes.edit', compact('frente'));
        return $frente;*/
        $frente = Frente::select('nombre', 'descripcion')
        ->where('idFrente', $id)
        ->first();
    
    if ($frente) {
        return response()->json(['frente' => $frente]);
    } else {
        return response()->json(['message' => 'Frente no encontrado'], 404);
    }
    
    }

    public function update(Request $request, $id)
    {
        // Valida los datos ingresados por el usuario
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);
    
        try {
            // Busca el frente por su ID
            $frente = Frente::findOrFail($id);
    
            // Actualiza los datos del frente
            $frente->nombre = $request->input('nombre');
            $frente->descripcion = $request->input('descripcion');
            $frente->save();
    
            return response()->json(['message' => 'Frente actualizado exitosamente'], 200);
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return response()->json(['message' => 'Algo salió mal al actualizar el frente'], 500);
        }
    }
   /* public function destroy($id)
    {
        // Busca el frente por su ID
        $frente = Frente::findOrFail($id);

        // Elimina el frente
        $frente->delete();

        // Redirecciona a la vista de índice de frentes con un mensaje de éxito
        return redirect()->route('frentes.index')->with('success', 'Frente eliminado exitosamente');
    }*/

    public function destroy($id)
    {
        // Busca y elimina los candidatos relacionados con el frente
        Candidato::where('idFrente', $id)->delete();
        
       

        // Luego, elimina el frente
        $frente = Frente::findOrFail($id);
        if (!$frente) {
            return response()->json(['message' => 'Frente no encontrado'], 404);
        }
        $frente->delete();
    
        // Redirecciona a la vista de índice de frentes con un mensaje de éxito
        //return redirect()->route('frentes.index')->with('success', 'Frente eliminado exitosamente');
        return response()->json(['message' => 'Frente eliminado exitosamente'], 200);
    }

    /*use Illuminate\Support\Facades\DB;
public function destroy($id)
{
    DB::beginTransaction();

    try {
        // Elimina los candidatos relacionados con el frente
        DB::table('candidatos')->where('idFrente', $id)->delete();

        // Luego, elimina el frente
        DB::table('frente')->where('id', $id)->delete();

        DB::commit();

        // Redirecciona a la vista de índice de frentes con un mensaje de éxito
        return redirect()->route('frentes.index')->with('success', 'Frente eliminado exitosamente');
    } catch (\Exception $e) {
        DB::rollback();

        // Manejar la excepción o mostrar un mensaje de error
        return redirect()->route('frentes.index')->with('error', 'Error al eliminar el frente');
    }
}

    */


}
