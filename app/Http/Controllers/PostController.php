<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $params = $request->all();

        $posts = Post::query();

        if (isset($params['search'])) {
            $posts->where('title', 'like', '%' . $params['search'] . '%');
        }

        return Inertia::render('Posts/Index', [
            'posts' => $posts->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Posts/Form', []);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $body = $request->all();

        $post = new Post();

        $post->title = $body['title'];
        $post->content = $body['content'];
        $post->slug = $body['slug'];
        $post->status = $body['status'];
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Inertia::render('Posts/Form', [
            'post' => Post::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $body = $request->all();

        $post = Post::find($id);

        $post->title = $body['title'];
        $post->content = $body['content'];
        $post->slug = $body['slug'];
        $post->status = $body['status'];
        $post->user_id = auth()->id();
        $post->save();

        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
