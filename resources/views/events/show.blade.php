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
                <td>{{ date('d/m/Y H:i', strtotime($event->date)) }}</td>
            </tr>
            <tr>
                <th>Lieu:</th>
                <td>{{ $event->lieu }}</td>
            </tr>
            <tr>
                <th>Organisateur:</th>
                <td>{{ $event->organizer->name }}</td>
            </tr>

        </table>
        @auth
            @if(Auth::user()->id === $event->organizer)
                <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Modifier l'événement</a>

                <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Supprimer</button>
                </form>
            @endif

            @if(Auth::user()->id !== $event->organizer && !$event->participants->contains(Auth::user()))
                <form action="{{ route('events.participate', $event->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">Participer à l'Événement</button>
                </form>
            @endif
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
