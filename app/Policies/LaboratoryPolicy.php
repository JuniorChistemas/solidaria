<?php

namespace App\Policies;

use App\Models\Laboratory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LaboratoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view laboratories');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Laboratory $laboratory): bool
    {
        return $user->can('view laboratories');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create laboratories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Laboratory $laboratory): bool
    {
        return $user->can(abilities: 'edit laboratories');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Laboratory $laboratory): bool
    {
        return $user->can(abilities: 'delete laboratories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Laboratory $laboratory): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Laboratory $laboratory): bool
    {
        return false;
    }
}
