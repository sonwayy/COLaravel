<?php

namespace App\Http\Controllers;

use App\Events\EventStarting;
use App\Mail\EventCreatedMail;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;


class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index', 'show');
    }

    public function index()
    {
        $today = Carbon::today(); // Aujourd'hui

        $events = Event::with('organizer')
        ->where('date', '>=', $today)
        ->orderBy('date', 'asc')
        ->paginate(5);

        return view('events.index', compact('events'));
    }

    public function create()
    {
        return view('events.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'lieu' => 'required|string|max:255'
            // Add more validation rules as needed
        ]);

        $event = Event::create([
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'lieu' => $request->input('lieu'),
            'organizer_id' => Auth::id()
            // Add other event attributes as needed
        ]);

        // Send email to the event organizer
        $organizer = User::find(Auth::id());
        $organizerMail = $organizer->email;
        $details = [
            'title' => 'Événement créé avec succès',
            'body' => 'Nous vous informons que votre événement a bien été créé.'
        ];

        Mail::to($organizerMail)->send(new EventCreatedMail($details));

        event(new EventStarting($event));

        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }

    public function participate(Event $event)
    {
        $user = auth()->user();

        // Vérifie si l'utilisateur n'est pas déjà inscrit à cet événement
        if ($event->participants()->where('user_id', $user->id)->exists()) {
            return redirect()->route('events.show', $event->id)->with('error', 'Vous participez déjà à cet événement.');
        }

        // Ajoute l'utilisateur comme participant de l'événement
        $event->participants()->attach($user);

        return redirect()->route('events.show', $event->id)->with('success', 'Vous participez à cet événement !');
    }

    public function edit(Event $event)
    {
        if (!Gate::allows('edit-event', $event)) {
            return redirect()->route('events.index')->with('error', 'You are not authorized to edit this event.');
        }

        return view('events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        // Use Gate to check if the user is authorized to update this event
        if (!Gate::allows('update-event', $event)) {
            return redirect()->route('events.index')->with('error', 'You are not authorized to update this event.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'lieu' => 'required|string|max:255|min:3'
            // Add more validation rules as needed
        ]);

        $event->update([
            'name' => $request->input('name'),
            'date' => $request->input('date'),
            'lieu' => $request->input('lieu'),
            // Update other event attributes as needed
        ]);

        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    public function userEvents()
    {
        $today = Carbon::today(); // Aujourd'hui

        $events = User::with('events')
            ->find(Auth::id())
            ->events()
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->paginate(5);

        return view('events.user_events', compact('events'));
    }

    public function participatingEvents()
    {
        $today = Carbon::today(); // Aujourd'hui

        $participatingEvents = User::with('participatingEvents')
            ->find(Auth::id())
            ->participatingEvents()
            ->where('date', '>=', $today)
            ->orderBy('date', 'asc')
            ->paginate(5);
        return view('events.participating_events', compact('participatingEvents'));
    }

    public function liveSearch(Request $request)
    {
        $query = $request->input('query');

        if ($query) {
            $events = Event::where('name', 'like', '%' . $query . '%')->get();
        } else {
            $events = Event::all();
        }

        return view('events._eventResults', compact('events'));
    }

}
