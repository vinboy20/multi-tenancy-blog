<?php

namespace App\Http\Controllers\api;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get();

        if ($posts->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No posts found',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data' => $posts
        ]);
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:255',
    //         'content' => 'required|string',
    //     ]);

    //     $userId = Auth::id();

    //     $user = User::where('id', $userId)->first();
    //     if (!$user) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }
    //     // Check if the user is approved
    //     if ($user->status !== User::STATUS_APPROVED) {
    //         return response()->json(['message' => 'Your account is not approved yet'], 403);
    //     }
    //     // Create a new post

    //     $post = Post::create([
    //         'title' => $request->title,
    //         'content' => $request->content,
    //         'user_id' => Auth::id(),
    //         // 'tenant_id' => Auth::user()->tenant_id,
    //         'tenant_id' => $user->tenant_id,
    //     ]);

    //     return response()->json($post, 201);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $user = Auth::user(); // Gets the authenticated user

        // Check if the user is approved
        if ($user->status !== User::STATUS_APPROVED) {
            return response()->json([
                'message' => 'Your account is not approved yet',
                'approval_pending' => true
            ], 403);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => $user->id,
            'tenant_id' => $user->tenant_id,
        ]);

        return response()->json([
            'message' => 'Post created successfully',
            'post' => $post,
            'author' => $user->only(['id', 'name', 'email'])
        ], 201);
    }

    public function show($id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);
        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $post->update($request->all());

        return response()->json($post);
    }

    public function destroy($id)
    {
        try {
            // Verify authentication first
            if (!Auth::check()) {
                return response()->json([
                    'message' => 'Authentication required',
                    'action' => 'Please log in to perform this action'
                ], 401);
            }

            // Find the post with ownership check
            $post = Post::where('user_id', Auth::id())->find($id);

            if (!$post) {
                return response()->json([
                    'message' => 'Post not found or you don\'t have permission',
                    'post_id' => $id,
                    'user_id' => Auth::id()
                ], 404);
            }

            // Additional check - verify tenant access if needed
            if (config('tenancy.enabled') && $post->tenant_id !== Auth::user()->tenant_id) {
                return response()->json([
                    'message' => 'Unauthorized cross-tenant operation',
                    'post_tenant' => $post->tenant_id,
                    'your_tenant' => Auth::user()->tenant_id
                ], 403);
            }

            // Attempt deletion
            if ($post->delete()) {
                return response()->json([
                    'message' => 'Post deleted successfully',
                    'deleted_post' => $id,
                    'timestamp' => now()->toDateTimeString()
                ]);
            }

            // If deletion fails silently
            return response()->json([
                'message' => 'Post deletion failed',
                'error' => 'Database operation failed'
            ], 500);
        } catch (\Exception $e) {
            // Catch any unexpected errors
            return response()->json([
                'message' => 'An error occurred during deletion',
                'error' => $e->getMessage(),
                'exception' => get_class($e)
            ], 500);
        }
    }
}
