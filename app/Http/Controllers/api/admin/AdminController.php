<?php

namespace App\Http\Controllers\api\admin;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Stancl\Tenancy\Database\Models\Domain;
use App\Models\Tenant;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // This controller is for admin functionalities
    // such as approving or rejecting users, and viewing all posts.
    public function pendingUsers()
    {
        $users = User::where('status', User::STATUS_PENDING)->get();
        return response()->json($users);
    }

    public function approveUser(Request $request, $userId)
    {

        $user = User::findOrFail($userId);

        // Generate a clean subdomain from the user's name
        // Extract the part before @ in email
        $subdomain = Str::slug(explode('@', $user->email)[0]); // john.doe@company.com → john-doe
        // $subdomain = Str::slug($user->email); // Converts "John Doe" to "john-doe"

        // Create tenant with explicit ID matching the subdomain
        $tenant = Tenant::create([
            'id' => $subdomain, // Use the slug as tenant ID
            'name' => $user->name . "'s Blog",
        ]);

        // Create human-readable domain (john-doe.localhost)
        $domain = Domain::create([
            'domain' => $subdomain . '.' . config('tenancy.central_domains')[0],
            'tenant_id' => $tenant->id,
        ]);

        // Update user
        $user->update([
            'tenant_id' => $tenant->id,
            'status' => User::STATUS_APPROVED,
        ]);

        return response()->json([
            'message' => 'User approved. Access at: ' . $domain->domain,
            'user' => $user,
            'tenant' => $tenant,
            'domain' => $domain,
        ]);
    }

    // public function rejectUser($userId)
    // {

    //     $user = User::findOrFail($userId);
    //     $user->update(['status' => User::STATUS_REJECTED]);
    //     return response()->json(['message' => 'User rejected successfully']);
    // }

    public function allPosts()
    {

        $tenants = Tenant::with('posts.user')->get();
        $posts = collect();

        foreach ($tenants as $tenant) {
            $posts = $posts->merge($tenant->posts);
        }

        return response()->json($posts);
    }
}
