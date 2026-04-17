<?php

namespace App\Policies;

use App\Models\MaintenanceRequest;
use App\Models\User;

class MaintenanceRequestPolicy
{
    /**
     * Determine whether the user can view any models (index).
     */
    public function viewAny(User $user): bool
    {
        // Admin and staff can see all; students see only their own (handled in controller)
        return $user->isAdmin() || $user->isStaff() || $user->isResident();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin() 
            || $user->isStaff() 
            || $user->id === $maintenanceRequest->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // Only students (residents) can create maintenance requests
        return $user->isResident();
    }

    /**
     * Determine whether the user can update the model (status, assignment).
     */
    public function update(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Admin can update any; staff can update assigned or unassigned (but not admin actions)
        // Students can update only their own pending requests (e.g., cancel)
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isStaff()) {
            // Staff can update status of any request (or at least those they are assigned to)
            return true;
        }
        if ($user->isResident() && $user->id === $maintenanceRequest->user_id && $maintenanceRequest->status === 'pending') {
            return true; // Student can cancel their own pending request
        }
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        // Only admin can delete maintenance requests
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MaintenanceRequest $maintenanceRequest): bool
    {
        return $user->isAdmin();
    }
}