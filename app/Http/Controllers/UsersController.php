<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\UserResource;

class UsersController extends Controller
{
    /**
     * Get the list of online users excluding the current authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOnlineUsers()
    {
        try {
            // Check if the user is authenticated
            if (!auth()->check()) {
                return response()->json(['users' => []], 200);
            }

            // Check if the users are cached
            $cachedUsers = Cache::get('online_users');
            if ($cachedUsers) {
                return response()->json(['users' => $cachedUsers], 200);
            }

            // Retrieve all users except the authenticated user, with unseen messages
            $users = User::with('unseenMessages')
                ->select('id', 'name', 'email') // Select only necessary columns for performance
                ->where('id', '!=', auth()->id())
                ->get();

            // Cache the result for 5 minutes
            Cache::put('online_users', $users, now()->addMinutes(5));

            // Return the list of users as a JSON response using a resource for better structure
            return response()->json(['users' => UserResource::collection($users)], 200);

        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Error fetching online users: ' . $e->getMessage());

            // Return a user-friendly error message
            return response()->json(['error' => 'Could not fetch online users at this time. Please try again later.'], 500);
        }
    }
}
