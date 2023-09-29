@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Mes Événements</h2>

        @if (!is_null($events) && count($events) > 0)
            <table class="table mt-4">
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
                            <a href="{{ route('events.edit', $event->id) }}" class="btn btn-primary">Modifier</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>Aucun événement trouvé.</p>
        @endif
    </div>
@endsection
