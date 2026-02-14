<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->paginate(10);
        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'required|string',
            'content'        => 'required|string',
            'category'       => 'required|string|max:100',
            'featured_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'           => 'nullable|string',
            'is_published'   => 'nullable|boolean',
        ]);

        $imagePath = $request->file('featured_image')
            ->store('blog', 'public');

        BlogPost::create([
            'title'          => $validated['title'],
            'slug'           => Str::slug($validated['title']),
            'excerpt'        => $validated['excerpt'],
            'content'        => $validated['content'],
            'category'       => $validated['category'],
            'featured_image' => $imagePath,
            'tags'           => $request->tags
                ? array_map('trim', explode(',', $request->tags))
                : null,
            'author_id'      => Auth::id(),
            'is_published'   => $request->has('is_published'),
            'published_at'   => $request->has('is_published') ? now() : null,
        ]);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Article créé avec succès');
    }

    public function edit(BlogPost $post)
    {
        return view('admin.blog.edit', compact('post'));
    }

    public function update(Request $request, BlogPost $post)
    {
        $validated = $request->validate([
            'title'          => 'required|string|max:255',
            'excerpt'        => 'required|string',
            'content'        => 'required|string',
            'category'       => 'required|string|max:100',
            'featured_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'tags'           => 'nullable|string',
            'is_published'   => 'nullable|boolean',
        ]);

        $imagePath = $post->featured_image;

        if ($request->hasFile('featured_image')) {
            if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $imagePath = $request->file('featured_image')->store('blog', 'public');
        }

        $post->update([
            'title'          => $validated['title'],
            'slug'           => Str::slug($validated['title']),
            'excerpt'        => $validated['excerpt'],
            'content'        => $validated['content'],
            'category'       => $validated['category'],
            'featured_image' => $imagePath,
            'tags'           => $request->tags
                ? array_map('trim', explode(',', $request->tags))
                : null,
            'is_published'   => $request->has('is_published'),
            'published_at'   => $request->has('is_published') ? now() : null,
        ]);

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Article mis à jour');
    }

    public function destroy(BlogPost $post)
    {
        if ($post->featured_image && Storage::disk('public')->exists($post->featured_image)) {
            Storage::disk('public')->delete($post->featured_image);
        }

        $post->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('success', 'Article supprimé');
    }
}
