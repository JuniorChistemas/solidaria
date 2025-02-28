<?php

namespace App\Policies;

use App\Models\Zone;
use App\Models\User;

class ZonePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view zones');
    }

    public function view(User $user, Zone $zone): bool
    {
        return $user->can('view zones');
    }

    public function create(User $user): bool
    {
        return $user->can('create zones');
    }

    public function update(User $user, Zone $zone): bool
    {
    return true; // ⚠️ SOLO PARA PRUEBA
    }

    public function delete(User $user, Zone $zone): bool
    {
        return $user->can('delete zones');
    }

    public function restore(User $user, Zone $zone): bool
    {
        return true;
    }

    public function forceDelete(User $user, Zone $zone): bool
    {
        return true;
    }
}