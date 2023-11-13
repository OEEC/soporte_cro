@extends('layout')

@section('content')
    <!-- Contenido específico de esta vista -->
    <h1>Supervisor</h1>
    <p>Control de Supervisores.</p>
    <div class="row">
        <div class="col-12">
            <form method="get" action="{{ route('supervisores.filtro') }}" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nombre">Nombre usuario:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" id="nombre">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="area">Persona:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="persona" id="persona">
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
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <table id="example" class="table table-striped table-bordered" style="width:90%">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Nombre</th>
                        <th>Correo</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-cuerpo">
                    @foreach($supervisores as  $supervisor)
                        <tr>
                            <td>{{$supervisor['usuario']}}</td>
                            <td>{{$supervisor['nombre']}}</td>
                            <td>{{$supervisor['correo']}}</td>
                            <td> 
                                <a class="btn btn-primary" href="{{ route('supervisores.estaciones', ['id' => $supervisor['id_usuario']]) }}">Ver estaciones</a> 
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