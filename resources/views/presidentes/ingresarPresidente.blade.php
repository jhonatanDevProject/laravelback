@extends('welcome')

@section('content')
    <div class="container">
        <h1>Ingresar Presidente</h1>
        <form method="POST" action="{{ route('presidentes.store') }}">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="apellido">Apellido</label>
                <input type="text" class="form-control" id="apellido" name="apellido" required>
            </div>
            <div class="form-group">
                <label for="ci">CI</label>
                <input type="text" class="form-control" id="ci" name="ci" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" id="correo" name="correo" required>
            </div>
            <div class="form-group">
                <label for="libreta">Libreta</label>
                <input type="text" class="form-control" id="libreta" name="libreta" required>
            </div>
            <div class="form-group">
                <label for="frente_id">Seleccionar Frente</label>
                <select class="form-control" id="frente_id" name="frente_id" required>
                    @foreach($frentes as $frente)
                        <option value="{{ $frente->id }}">{{ $frente->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Presidente</button>
        </form>
    </div>
@endsection
