@extends('layouts.app')

@section('content')
    <h1>{{ $evento->nombre }}</h1>
    <p>{{ $evento->descripcion }}</p>
    <p><strong>Fecha:</strong> {{ $evento->fecha->format('d/m/Y') }}</p>

    {{-- Mostrar lista de alumnos y sus archivos SOLO para admins --}}
    @can('viewAny', App\Models\User::class)
        <h4 class="mt-4">Alumnos inscritos:</h4>
        @forelse ($evento->users as $alumno)
            <div class="mb-2">
                <strong>{{ $alumno->name }} ({{ $alumno->email }})</strong>
                <ul>
                    @foreach ($evento->archivos->where('user_id', $alumno->id) as $archivo)
                        <li>{{ $archivo->nombre }}</li>
                    @endforeach
                </ul>
            </div>
        @empty
            <p>No hay alumnos inscritos en este evento.</p>
        @endforelse
    @endcan
@endsection
