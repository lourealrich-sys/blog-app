<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $posts = $request->user()->posts()->latest()->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('posts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post = $request->user()->posts()->create($validated);

        return redirect()->route('posts.show', $post)->with('status', 'Post created successfully.');
    }

    public function show(Request $request, Post $post): View
    {
        $post = $request->user()->posts()->findOrFail($post->id);

        return view('posts.show', compact('post'));
    }

    public function edit(Request $request, Post $post): View
    {
        $post = $request->user()->posts()->findOrFail($post->id);

        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $post = $request->user()->posts()->findOrFail($post->id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ]);

        $post->update($validated);

        return redirect()->route('posts.show', $post)->with('status', 'Post updated successfully.');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $post = $request->user()->posts()->findOrFail($post->id);
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted successfully.');
    }
}
