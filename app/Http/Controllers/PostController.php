<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $categories = Category::get();
        // $posts = Post::orderBy('created_at', 'DESC')->get();
        // $posts = Post::orderBy('created_at', 'DESC')->paginate(5);

        DB::listen(function ($query) {
            Log::info($query->sql);
        });

        $posts = Post::with(['user', 'media'])
            ->withCount('claps')
            ->latest()
            ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view("post.create", [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        // Validating post data
        $data = $request->validated();

        // Image: Creation of Url Of The image and storing it in the storage 
        // $image = $data['image'];
        // $imagePath = $image->store('posts', 'public');
        // $data['image'] = $imagePath;

        // adding id of the user
        $data['user_id'] = FacadesAuth::id();

        // la création de post
        $post = Post::create($data);
        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')->toMediaCollection();
        }
        // redirection vers la page dashboard
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }

        $categories = Category::get();
        return view('post.update', [
            'post' => $post,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostCreateRequest $request, Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }
        $data = $request->validated();

        // Updating the post
        $post->update($data);

        // Image: Creation of Url Of The image and storing it in the storage
        if ($request->hasFile('image')) {
            // Clear and replace only in the "images" collection
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')->toMediaCollection();
        }

        // Redirection
        return redirect()->route('myPosts');
    }

    /**<
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            abort(403);
        }
        $post->clearMediaCollection(); // Clear media collection before deleting the post
        // Delete the post
        $post->delete();
        return redirect()->route('dashboard');
    }

    /**
     * Display posts by category.
     *
     */
    public function category(Category $category)
    {
        $posts = $category->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts
        ]);
    }

    /**
     * Display posts by authenticated user.
     *
     */

    public function myPosts()
    {
        $user = auth()->user();
        $posts = $user->posts()
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest()->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts
        ]);
    }
}
