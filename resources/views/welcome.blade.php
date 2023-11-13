@extends('layout')

@section('content')
    <!-- Contenido específico de esta vista -->
    <h1>Control de usuarios</h1>
    <div class="row">
        <div class="col-12">
            <p><strong>Filtro de usuarios:</strong></p>
            <form method="post" action="{{ route('usuarios.filtro') }}" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nombre">Nombre usuario:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" id="nombre">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="area">Area:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="area" id="area">
                            <option value="0" selected>No seleccionado</option>
                            @foreach ( $areas as $area)
                                <option value="{{$area->id_area}}">{{$area->id_area}} - {{$area->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo" id="tipo">
                            <option value="0" selected>No seleccionado</option>
                            @foreach ( $tipos as $tipo)
                                <option value="{{$tipo->id_tipo}}">{{$tipo->id_tipo}} - {{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Estatus:</label>
                    <div class="col-sm-10">
                        <select name="estatus" id="estatus">
                            <option value="0" selected>No seleccionado</option>
                            <option value="1">Activo</option>
                            <option value="2">Baja</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-12">
            <p><strong>Listado de usuarios:</strong></p>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <table id="example" class="table table-striped table-bordered" style="width:90%">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Password</th>
                        <th>Area</th>
                        <th>Tipo usuario</th>
                        <th>Nombre</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-cuerpo">
                    @foreach($usuarios as $usuario)
                        <tr>
                            <td>{{$usuario['usuario']}}</td><!--Usuario-->
                            <td>{{$usuario['contrasena']}}</td><!--Password-->
                            <td>{{$usuario['area']}} - {{$usuario['nombre_area']}}</td><!--Area-->
                            <td>{{$usuario['tipo']}} - {{$usuario['nombre_tipo']}}</td><!--tipo usuario-->
                            <td>{{$usuario['tipo_foraneo']}}</td><!--foraneo-->
                            <td>{{$usuario['estatus'] == 1 ? "Activo" : "Baja"; }}</td><!--estatus-->
                            <td> 
                                <a class="btn btn-primary" href="{{ route('usuario.ver', ['id' => $usuario['id_usuario']]) }}">Actualizar</a> 
                                @if($usuario['estatus'] == 1)
                                <a class="btn btn-danger" href="{{ route('usuario.baja', ['id' => $usuario['id_usuario']]) }}">Baja</a>
                                @else
                                <a class="btn btn-success" href="{{ route('usuario.baja', ['id' => $usuario['id_usuario']]) }}">Alta</a>
                                @endif 
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
        </div>
    </div>
@endsection