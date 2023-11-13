@extends('layout')

@section('content')
    <!-- Contenido específico de esta vista -->
    <h1>Estaciones asignadas</h1>
    <div class="row">
        <div class="col-12">
            <h4>Asignar una estacion:</h4>
            <form method="post" action="{{ route('asignar.supxest', ['id' => $id_usuario]) }}" class="form-horizontal">
                @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Estación:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="estacion" id="estacion">
                            <option value="0" selected>No seleccionado</option>
                            @foreach ( $estaciones as $estacion)
                                <option value="{{$estacion->id_estacion}}">{{$estacion->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Asignar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="padding-top: 15px;">
        <div class="col-12">
            <h4>Estaciones asignada a supervisor <b>{{$usuario_nombre}}</b>.</h4>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
            <table id="example" class="table table-striped table-bordered" style="width:90%">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Accion</th>
                    </tr>
                </thead>
                <tbody id="tabla-cuerpo">
                    @foreach($supervisorEstaciones as  $supxest)
                        <tr>
                            <td>{{$supxest['estacion_nombre']}}</td>
                            <td>{{$supxest['direccion']}} {{$supxest['municipio']}} {{$supxest['estado']}}</td>
                            <td> 
                                <a class="btn btn-danger" href="{{ route('borrar.supxest', ['id' => $supxest['id_sxe']]) }}">Eliminar estacion</a> 
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