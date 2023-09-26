@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Créer un Événement</h2>
        <form action="{{ route('events.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nom de l'Événement:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="form-group">
                <label for="date">Date de l'Événement:</label>
                <input type="datetime-local" class="form-control" id="date" name="date">
            </div>
            <div class="form-group">
                <label for="date">Lieu de l'Événement:</label>
                <input type="text" class="form-control" id="lieu" name="lieu">
            </div>
            <button type="submit" class="btn btn-primary">Créer</button>
        </form>
    </div>
@endsection
