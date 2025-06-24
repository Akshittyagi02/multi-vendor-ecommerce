<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfile
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();

            // Define what constitutes an incomplete profile.
            // You can customize this logic based on your application's requirements.
            // For example, check for specific fields in the User model,
            // or check if related profile models exist and are complete.
            $isProfileIncomplete = empty($user->name) || empty($user->email);

            // Add more checks for specific profile fields if necessary.
            // Example: If you have a 'phone_number' column on the users table:
            // $isProfileIncomplete = $isProfileIncomplete || empty($user->phone_number);

            // Example: If you have a separate UserProfile model:
            // if (!$user->profile || empty($user->profile->address) || empty($user->profile->city)) {
            //     $isProfileIncomplete = true;
            // }

            // If the profile is incomplete and the current route is not the profile edit page
            // or the logout route (to prevent redirect loops), redirect them.
            if ($isProfileIncomplete && !$request->routeIs('profile.edit') && !$request->routeIs('logout')) {
                // Flash a warning message to the session
                session()->flash('error', __('messages.complete_profile_warning'));
                return redirect()->route('profile.edit');
            }
        }

        return $next($request);
    }
}
