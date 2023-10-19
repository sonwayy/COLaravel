<!-- events/_eventResults.blade.php -->

<table>
    <!-- Display events dynamically here -->
    @foreach($events as $event)
        <tr>
            <td>{{ $event->name }}</td>
            <!-- Display other event details -->
        </tr>
    @endforeach
</table>
