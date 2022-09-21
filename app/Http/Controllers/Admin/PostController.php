<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    private $validationRules = [
        'title' => 'min:3|max:255|required',
        'post_content' => 'min:3|required',
        'post_image' => 'active_url',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post();
        return view('admin.posts.create', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->validationRules);
        $sentData = $request->all();
        $sentData['author'] = Auth::user()->name;
        date_default_timezone_set('Europe/Rome');
        $sentData['post_date'] = new DateTime();
        $post = new Post();
        $lastPostId = Post::orderBy('id', 'desc')->first();
        $sentData['slug'] = Str::slug($sentData['title'], '-'). '-' . ($lastPostId->id + 1);

        $post->create($sentData);

        return redirect()->route('admin.posts.show', $sentData['slug'])->with('created', $sentData['title']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $sentData = $request->validate($this->validationRules);
        $post = Post::where('slug', $slug)->firstOrFail();
        $sentData['slug'] = Str::slug($sentData['title'], '-'). '-' . ($post->id);
        $post->update($sentData);

        return redirect()->route('admin.posts.show', $post->slug)->with('edited', $sentData['title']); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('admin.posts.index')->with('delete', $post->title);
    }
}
