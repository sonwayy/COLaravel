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
            @foreach($events as $event)
                <tr>
                    <td>{{ $event->name }}</td>
                    <td>{{ date('d/m/Y H:i', strtotime($event->date)) }}</td>
                    <td>{{ $event->lieu }}</td>
                    <td>
                        <a href="{{ route('events.show', $event->id) }}" class="btn btn-info">Voir</a>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $events->links() }}
    </div>

    <!-- JavaScript for Ajax and Live Search -->
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>

    <script>
        $(document).ready(function() {
            $('#search').on('keyup', function() {
                let query = $(this).val();
                console.log('jQuery is working!');

                $.ajax({
                    url: "{{ route('events.liveSearch') }}",
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
