<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class EventPolicy
{

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only logged in users can create events
        return $user->id !== null;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Event $event): Response
    {
        return $user->id === $event->organizer
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas l\'organisateur de cet événement.');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Event $event): bool
    {
        return $user->id === $event->organizer;
    }

}
