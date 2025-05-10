@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Lista de Eventos</h1>

    {{-- Botón para crear eventos (solo admin) --}}
    @can('create', App\Models\Evento::class)
        <div class="mb-3 text-end">
            <a href="{{ route('eventos.create') }}" class="btn btn-success">➕ Crear nuevo evento</a>
        </div>
    @endcan

    {{-- Mostrar mensajes flash de éxito/error --}}
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    @if ($eventos->isEmpty())
        <div class="alert alert-info">
            No hay eventos disponibles por ahora.
        </div>
    @else
        <div class="row">
            @foreach ($eventos as $evento)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $evento->nombre }}</h5>
                            <p class="card-text">{{ $evento->descripcion }}</p>
                            <p class="card-text">
                                <small class="text-muted">Fecha: {{ $evento->fecha->format('d/m/Y') }}</small>
                            </p>

                            <div class="mt-auto">
                                @auth
                                    {{-- Chequear si está inscrito usando la tabla pivote directamente --}}
                                    @php
                                        $yaInscrito = DB::table('evento_user')
                                            ->where('evento_id', $evento->id)
                                            ->where('user_id', Auth::id())
                                            ->exists();
                                    @endphp

                                    @can('delete', $evento)
                                        <form action="{{ route('eventos.destroy', $evento) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Eliminar evento</button>
                                        </form>

                                        {{-- NUEVO BOTÓN para ver inscritos --}}
                                        <a href="{{ route('eventos.show', $evento) }}" class="btn btn-info btn-sm mt-2">Ver inscritos</a>
                                        @endcan


                                    @if ($yaInscrito)
                                        {{-- Botón de inscrito --}}
                                        <button class="btn btn-success btn-sm mb-2" disabled>✅ Ya inscrito</button>

                                        {{-- Formulario para subir archivos --}}
                                        <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="evento_id" value="{{ $evento->id }}">
                                            <div class="mb-2">
                                                <input type="file" name="archivo" class="form-control" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-sm">Subir archivo</button>
                                        </form>

                                        {{-- Mostrar archivos subidos --}}
                                        @if ($evento->archivos->where('user_id', Auth::id())->count() > 0)
                                            <div class="mt-3">
                                                <h6 class="fw-bold">Tus archivos:</h6>
                                                <ul class="list-group list-group-flush">
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
                                        @endif

                                    @else
                                        {{-- Botón para inscribirse --}}
                                        @if (!Auth::user()->is_admin)
                                            <form action="{{ route('eventos.inscribirse', $evento) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Inscribirse</button>
                                            </form>
                                            @endif
                                    @endif
                                @else
                                    {{-- Mostrar bonito mensaje cuando no está logueado --}}
                                    <div class="alert alert-info mt-3 text-center">
                                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">Inicia sesión para inscribirte</a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
