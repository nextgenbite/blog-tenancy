<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->get();
        return view('tenant.admin.post.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('tenant.admin.post.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $plan = tenant()->plan;
        $postCount = Post::count();

        if ($plan->max_posts && $postCount >= $plan->max_posts) {
            abort(403, 'Plan limit reached');
        }


        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'tenant_id' => tenant()->id,
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'is_published' => $request->is_published ?? false,
        ]);

        return redirect()->route('post.index')->with('success', __('Post created successfully.'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('tenant.admin.post.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
            'is_published' => 'boolean',
        ]);

        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . uniqid(),
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->is_published ?? false,
        ]);

        return redirect()->route('post.index')->with('success', __('Post updated successfully.'));
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('post.index')->with('success', __('Post deleted successfully.'));
    }
}
