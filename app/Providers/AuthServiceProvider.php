<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate; // Import the Gate facade
use App\Models\User; // Import the User model

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define an "admin" Gate
        Gate::define('admin', function (User $user) {
            // This gate now checks if the 'is_admin' column on the User model is true.
            return $user->hasRole('admin') && $user->is_admin; // Assuming 'is_admin' is a boolean column
        });

        // You can also define other gates here, e.g., for 'vendor'
        Gate::define('vendor', function (User $user) {
            // Check if the user has the 'vendor' role AND if their vendor profile is approved
            // You might want to keep hasRole('vendor') if you still use Spatie for that role.
            return $user->hasRole('vendor') && $user->vendor && $user->vendor->is_approved;
        });

        // Define a 'customer' Gate
        Gate::define('customer', function (User $user) {
            return $user->hasRole('customer');
        });
    }
}
