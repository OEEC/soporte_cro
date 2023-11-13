<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Estacion;
use App\Models\Jefeturno;
use App\Models\Persona;
use App\Models\Tipo;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index(){
        try{
            //Consulta para trear la informacion general del usuario, con su area y tipo
            $usuarios = [];
            $usuario = Usuario::join('area', 'area.id_area', 'usuario.area')
                                ->leftjoin('tipo','id_tipo', 'usuario.tipo')
                                ->select('usuario.id_usuario','usuario.usuario','usuario.contrasena',
                                'area.nombre as nombre_area','usuario.area',
                                'usuario.tipo', 'tipo.nombre as nombre_tipo', 'usuario.id_foraneo','usuario.estatus')
                                ->get();
            //Dependiendo del tipo del usuario se relaciona el id_foraneo
            foreach($usuario as $user){
                //Si es usuario de estacion busca el nombre de la estacion con el id_foraneo 
                if($user->tipo == 3){
                    $tipo_foraneo = Estacion::find($user->id_foraneo);
                    $tipo_foraneo = $tipo_foraneo->nombre;
                } else if($user->tipo == 9){
                    //Si es usuario es jefe de turno busca el nombre del jefe de turno con el id_foraneo 
                    $tipo_foraneo = Jefeturno::find($user->id_foraneo);
                    $tipo_foraneo = $tipo_foraneo->nombre;
                } else if( $user->tipo == 1 || $user->tipo == 2 ||  $user->tipo == 5 || $user->tipo == 6){
                    //Si es usuario de lider, auxiliar, admin general y gestor busca el nombre de la persona con el id_foraneo 
                    $tipo_foraneo = Persona::find($user->id_foraneo);
                    $tipo_foraneo = $tipo_foraneo->nombre;
                } else {
                    $tipo_foraneo = null;
                }
                //Se arma un arreglo para mostrar los datos ya armados para la vista
                $u = array(
                    "id_usuario" => $user->id_usuario,
                    "usuario" => $user->usuario,
                    "contrasena" => $user->contrasena,
                    "nombre_area" => $user->nombre_area,
                    "area" => $user->area,
                    "tipo" => $user->tipo,
                    "nombre_tipo" => $user->nombre_tipo,
                    "id_foraneo" => $user->id_foraneo,
                    "tipo_foraneo" => $tipo_foraneo,
                    "estatus" => $user->estatus
                );
                array_push($usuarios, $u);
            }
           //Se traen el area y el tipo para mostrar en los select de la vista 
           $areas = Area::all();
           $tipos = Tipo::all();
           //Se mandan el usuarios, las areas y los tipos a la vista de usuarios 
            return view('welcome',[
                'usuarios' => $usuarios,
                'areas' => $areas,
                'tipos' => $tipos 
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function filtro_usuarios(Request $request){
        try {
            //traemos todos los campos dentro request
            $filtros = $request->all();
            $usuarios = [];
            //Se traen el area y el tipo para mostrar en los select de la vista 
            $areas = Area::all();
            $tipos = Tipo::all();
            // Consulta para filtrar usuario en base a los filtros
            $usuario = Usuario::join('area', 'area.id_area', 'usuario.area')
            ->leftjoin('tipo','id_tipo', 'usuario.tipo')
            ->select('usuario.id_usuario','usuario.usuario','usuario.contrasena',
            'area.nombre as nombre_area','usuario.area',
            'usuario.tipo', 'tipo.nombre as nombre_tipo', 'usuario.id_foraneo','usuario.estatus');
            //Validacion de campos enviados en el formualrio
            if(isset($filtros['nombre']) || isset($filtros['area']) || isset($filtros['tipo']) || isset($filtros['estatus'])){
                //Dependiendo de los campos enviados realiza la consulta
                if($filtros['nombre'] != null){
                    $usuario->where('usuario.usuario', $filtros['nombre']);
                }
                if($filtros['area'] != 0){
                    $usuario->where('usuario.area', $filtros['area']);
                }
                if($filtros['tipo'] != 0){
                    $usuario->where('usuario.tipo', $filtros['tipo']);
                }
                if($filtros['estatus'] != 0){
                    $usuario->where('estatus', $filtros['estatus']);
                }
                
            }
            $usuario = $usuario->get();
            //Dependiendo del tipo del usuario se relaciona el id_foraneo
            foreach($usuario as $user){
                //Si es usuario de estacion busca el nombre de la estacion con el id_foraneo 
                $tipo_foraneo = $this->tipo_foraneo($user);
                //Se arma un arreglo para mostrar los datos ya armados para la vista
                $u = array(
                    "id_usuario" => $user->id_usuario,
                    "usuario" => $user->usuario,
                    "contrasena" => $user->contrasena,
                    "nombre_area" => $user->nombre_area,
                    "area" => $user->area,
                    "tipo" => $user->tipo,
                    "nombre_tipo" => $user->nombre_tipo,
                    "id_foraneo" => $user->id_foraneo,
                    "tipo_foraneo" => $tipo_foraneo,
                    "estatus" => $user->estatus
                );
                array_push($usuarios, $u);
            }  
        //Se mandan el usuarios, las areas y los tipos a la vista de usuarios 
             return view('welcome',[
                 'usuarios' => $usuarios,
                 'areas' => $areas,
                 'tipos' => $tipos 
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function usuario_ver($id) {
        try{
            // Busca el usuario
            $usuario = Usuario::find($id);
            //Se traen el area y el tipo para mostrar en los select de la vista 
            $areas = Area::all();
            $tipos = Tipo::all();
             //Se mandan el usuarios, las areas y los tipos a la vista de actualizar usuario
             return view('usuarios.update',[
                 'usuario' => $usuario,
                 'areas' => $areas,
                 'tipos' => $tipos 
            ]);
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function usuario_actualizar(Request $request, $id) {
        try {
        // Valida los datos del formulario
       $validacion = $request->validate([
            'nombre' => 'required',
            'password' => 'required',
        ]);

        $dato = $request->all();
        // Actualiza los datos del usuario
        $usuario = Usuario::find($id);
        $usuario->usuario = $dato['nombre'];
        $usuario->contrasena = $dato['password'];
        $usuario->area = $dato['area'];
        $usuario->tipo = $dato['tipo'];
        if($usuario->save()){
            return redirect()->back()->with('success', 'Usuario actualizado correctamente');
        } else {
            return back()->withError('Algo salio mal al actualizar');
        }
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function usuario_baja($id) {
        try{
            //Buscar al id del usario para traer su informacion
            $usuario = Usuario::find($id);
            $tipo_foraneo = "";
            $area = Area::find($usuario->area);
            $tipo = Tipo::find($usuario->tipo);
            $tipo_foraneo = $this->tipo_foraneo($usuario);
            return view('usuarios.delete',[
                 'usuario' => $usuario,
                 'area' => $area->nombre,
                 'tipo' => $tipo->nombre,
                 'tipo_foraneo' => $tipo_foraneo 
            ]);
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }

    public function delete($id){
        try {
            $usuario = Usuario::find($id);
            //Si el estatus es 1 lo da de baja si no es alta
            if($usuario->estatus == 1){
                $usuario->estatus = 2;
                if($usuario->save()){
                    return redirect()->route('usuarios')->with('success', 'Usuario dado de baja');
                } else {
                    return back()->withError('Hubo un problema al dar de baja el usuario');
                }
            } else {
                $usuario->estatus = 1;
                if($usuario->save()){
                    return redirect()->route('usuarios')->with('success', 'Usuario dado de baja');
                } else {
                    return back()->withError('Hubo un problema al dar de baja el usuario');
                }
            }
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }

    }

    public function tipo_foraneo(Usuario $usuario) {
        try{
            if($usuario->tipo == 3){
                //Si es el usuario es una estacion busca el nombre de la estacion con el id_foraneo 
                $tipo_foraneo = Estacion::find($usuario->id_foraneo);
                $tipo_foraneo = $tipo_foraneo->nombre;
            } else if($usuario->tipo == 9){
                //Si es usuario es jefe de turno busca el nombre del jefe de turno con el id_foraneo 
                $tipo_foraneo = Jefeturno::find($usuario->id_foraneo);
                $tipo_foraneo = $tipo_foraneo->nombre;
            } else if( $usuario->tipo == 1 || $usuario->tipo == 2 ||  $usuario->tipo == 5 || $usuario->tipo == 6){
                //Si es usuario de lider, auxiliar, admin general y gestor busca el nombre de la persona con el id_foraneo 
                $tipo_foraneo = Persona::find($usuario->id_foraneo);
                $tipo_foraneo = $tipo_foraneo->nombre;
            } else {
                $tipo_foraneo = null;
            }
    
            return $tipo_foraneo;
        } catch (\Exception $e) {
            return back()->withError($e->getMessage());
        }
    }
}
