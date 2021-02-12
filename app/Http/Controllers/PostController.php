<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Exceptions\UnauthorizedException;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->hasPermissionTo('Criar Artigo')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $post->title = $request->title;
        $post->content = $request->content;

        if(!empty($request->published)) {
            $post->published = $request->published;
        }

        $post->save();

        return redirect()->route('post.edit', [
            'post' => $post->id,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Editar Artigo')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        return view('posts.edit', [
            'post' => $post
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Editar Artigo')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $post->title = $request->title;
        $post->content = $request->content;

        if(isset($request->published)) {
            $post->published = $request->published;
        }

        $post->save();
        return redirect()->route('post.edit', [
            'post' => $post->id,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        if (!Auth::user()->hasPermissionTo('Remover Artigo')) {
            throw new UnauthorizedException('403', 'You do not have the required authorization.');
        }

        $post->delete();
        return redirect()->route('post.index');
    }
}
