<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\Estacion;
use App\Models\Persona;
use App\Models\Supxest;
use Illuminate\Http\Request;

class SupervisorController extends Controller
{
    public function index(){
        try{
             //Consulta para trear la informacion general del usuario supervisor
            $supervisores = Usuario::leftjoin('persona', 'persona.id_persona', 'usuario.id_foraneo')
            ->where('usuario.area', 18)
            ->where('usuario.tipo', 1)
            ->get();

            $estaciones = Estacion::all();
            //Asignacion de parametros para la vista
            return view('supervisores.index',[
                'supervisores' => $supervisores,
                'estacion' => $estaciones 
            ]);
        } catch(\Exception $e){
            return back()->withError($e->getMessage());
        }
    }

    public function supervisor_filtros(Request $request){
        try {
            $data = $request->all();
            //Consulta para trear la informacion general del usuario supervisor
            $supervisores = Usuario::leftjoin('persona', 'persona.id_persona', 'usuario.id_foraneo')
                                ->where('usuario.area', 18)
                                ->where('usuario.tipo', 1);
            if(isset($data['nombre']) || isset($data['persona'])){
               if($data['nombre'] != null){
                $supervisores = $supervisores->where('usuario.usuario', $data['nombre']);
               } else if($data['persona'] != null) {
                $supervisores = $supervisores->where('persona.nombre', 'like', '%' .$data['persona']. '%');
               }
            }
            $supervisores = $supervisores->get();
           // dd($supervisores);

            $estaciones = Estacion::all();
            //Asignacion de parametros para la vista
            return view('supervisores.index',[
                'supervisores' => $supervisores,
                'estacion' => $estaciones 
            ]);

        } catch(\Exception $e){
            return back()->withError($e->getMessage());
        }
    }

    public function supervisores_estaciones($id){
        try{
            //Consulta de estaciones asignadas en el supervisor
            $supervisorEstaciones = Estacion::join('supxest', 'supxest.estacion', 'estacion.id_estacion')
            ->join('usuario', 'usuario.id_usuario', 'supxest.supervisor')
            ->join('persona', 'persona.id_persona', 'usuario.id_foraneo')
            ->select('id_sxe','id_usuario', 'id_estacion', 'persona.nombre as persona_nombre','estacion.nombre as estacion_nombre', 'direccion', 'municipio', 'estado')
            ->where('usuario.id_usuario', $id)
            ->get();

            $estaciones = Estacion::all();
            $usuario = Usuario::find($id);
            $persona = Persona::find($usuario->id_foraneo);
            //Asignacion de parametros para la vista
            return view('supervisores.estaciones',[
                'supervisorEstaciones' => $supervisorEstaciones,
                'estaciones'=> $estaciones,
                'usuario_nombre' => $persona->nombre,
                'id_usuario' => $usuario->id_usuario,
            ]);
        } catch(\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function asignar_estacion(Request $request, $id){
        try{
            //Traer los datos del request
            $data = $request->all();
            //Se crea un nuevo supervisor x estacion y se le asignan los datos del id_estacion y el id del supervisor 
            $supxest = new Supxest();
            $supxest->estacion = $data['estacion'];
            $supxest->supervisor = $id;
            if($supxest->save()){
                return redirect()->back()->with('success', 'Estacion asignada correctamente');
            } else {
                return back()->withError('Hubo un problema para asignar la estacion');
            }
        } catch(\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function borrar_supxest($id){
        try {
            // Encuentra el usuario por ID
            $supxest = Supxest::findOrFail($id);

            // Realiza la operación de eliminación
            $supxest->delete();

            // Redirige con un mensaje de éxito
            return redirect()->back()->with('success', 'Estacion desasignada correctamente');
        } catch(\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
}
