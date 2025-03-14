<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        // return $user->hasPermissionTo('view categories');
        return $user->can('view categories');
        // return $user->hasRole('admin'); 
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Category $category): bool
    {
        return $user->can('view categories');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create categories');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Category $categories): bool
    {
        return $user->can('update categories');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Category $categories): bool
    {
        return $user->can('delete categories');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Category $categories): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Category $categories): bool
    {
        return true;
    }
}
