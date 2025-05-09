@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Mis Cursos Inscritos</h1>

    @if ($misEventos->isEmpty())
        <div class="alert alert-info">
            No estás inscrito en ningún curso todavía.
        </div>
    @else
        <div class="row">
            @foreach ($misEventos as $evento)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{ $evento->nombre }}</h5>
                            <p class="card-text">{{ $evento->descripcion }}</p>
                            <p class="card-text">
                                <small class="text-muted">Fecha: {{ $evento->fecha->format('d/m/Y') }}</small>
                            </p>

                            {{-- Mostrar archivos subidos para este evento --}}
                            @if ($evento->archivos->where('user_id', Auth::id())->count() > 0)
                                <div class="mt-3">
                                    <h6>Tus archivos:</h6>
                                    <ul class="list-group">
                                        @foreach ($evento->archivos->where('user_id', Auth::id()) as $archivo)
                                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                                {{ $archivo->nombre }}
                                                <form action="{{ route('archivos.destroy', $archivo) }}" method="POST" class="ms-2">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <p class="text-muted mt-2">No has subido archivos para este curso.</p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
