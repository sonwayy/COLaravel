@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Détails de l'Événement</h2>
        <table class="table mt-4">
            <tr>
                <th>Nom:</th>
                <td>{{ $event->name }}</td>
            </tr>
            <tr>
                <th>Date:</th>
                <td>{{ $event->date }}</td>
            </tr>
            <tr>
                <th>Lieu:</th>
                <td>{{ $event->lieu }}</td>
            </tr>
            <!-- Ajoute d'autres détails de l'événement si nécessaire -->
        </table>
        @auth
            <form action="{{ route('events.participate', $event->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Participer à l'Événement</button>
            </form>
        @else
            <p>Vous devez être connecté pour participer à cet événement.</p>
        @endauth

        <h3>Participants :</h3>
        <ul>
            @forelse ($event->participants as $participant)
                <li>{{ $participant->name }}</li>
            @empty
                <li>Aucun participant pour le moment.</li>
            @endforelse
        </ul>

        <a href="{{ route('events.index') }}" class="btn btn-secondary">Retour</a>
    </div>
@endsection
