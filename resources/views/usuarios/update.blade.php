@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h3>Actualizando a usuario <strong>{{$usuario->usuario}}</strong></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form method="POST" action="{{ route('usuario.actualizar', ['id' => $usuario->id_usuario]) }}" class="form-horizontal">
              @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nombre">Nombre usuario:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{$usuario->usuario}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="password">Password:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="password" id="contrasena" value="{{$usuario->contrasena}}">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="area">Area:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="area" id="area">
                            @foreach ( $areas as $area)
                                <option value="{{$area->id_area}}" {{$area->id_area == $usuario->area ? 'selected' : '' }}>{{$area->id_area}} - {{$area->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                    <div class="col-sm-10">
                        <select class="form-control" name="tipo" id="tipo">
                            @foreach ( $tipos as $tipo)
                                <option value="{{$tipo->id_tipo}}" {{$usuario->tipo == $tipo->id_tipo ? 'selected' : '' }}>{{$tipo->id_tipo}} - {{$tipo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">Enviar</button>
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection