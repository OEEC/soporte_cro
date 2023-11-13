@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6">
            <h3>Dar de baja a usuario <strong>{{$usuario->usuario}}</strong></h3>
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
            <form method="GET" action="{{ route('usuario.delete', ['id' => $usuario->id_usuario]) }}" class="form-horizontal">
              @csrf
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nombre">Nombre usuario:</label>
                    <div class="col-sm-10">
                        <p>{{$usuario->usuario}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="area">Area:</label>
                    <div class="col-sm-10">
                        <p>{{$area}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                    <div class="col-sm-10">
                        <p>{{$tipo}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="tipo">Foraneo:</label>
                    <div class="col-sm-10">
                        <p>{{$tipo_foraneo}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        @if($usuario->estatus == 2)
                            <button type="submit" class="btn btn-primary">Dar de alta</button>
                        @else
                            <button type="submit" class="btn btn-primary">Dar de baja</button>
                        @endif
                        <a href="{{ url()->previous() }}" class="btn btn-danger">Cancelar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection