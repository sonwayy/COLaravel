<!-- events/_eventResults.blade.php -->

<table>
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
