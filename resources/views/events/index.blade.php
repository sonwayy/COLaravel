@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mt-4">Liste des Événements</h2>

        @auth
            <a href="{{ route('events.create') }}" class="btn btn-primary mb-3">Créer un événement</a>
        @endauth

    <!-- Live Search -->
        <input type="text" id="search" placeholder="Rechercher">

        <table class="table" id="event-results">
            <!-- Display events dynamically here -->
            <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Organisateur</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($event->date)) }}</td>
                    <td>{{ $event->lieu }}</td>
                    <td>{{ $event->organizer->name }}</td>
                    <td>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        {{ $events->links() }}
    </div>

    <!-- JavaScript for Ajax and Live Search -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $.noConflict();
        jQuery(document).ready(function($) {
            $('#search').on('keyup', function() {

                let query = $(this).val();
                console.log('jQuery is working!');

                $.ajax({
                    url: "{{ route('livesearch') }}",
                    method: "GET",
                    data: { query: query },
                    success: function(response) {
                        $('#event-results').html(response);
                    }
                });
            });
        });
    </script>
@endsection
