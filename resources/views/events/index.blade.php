@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">Liste des Événements</h2>

        @auth
            <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Créer un événement</a>
        @endauth

        <table class="table">
            <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ $event->date }}</td>
                    <td>{{ $event->lieu }}</td>
                    <td>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
