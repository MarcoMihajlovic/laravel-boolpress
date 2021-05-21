<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'posts' => Post::all()
        ];

        return view('admin.posts.index', $data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request-> validate([
            'title' => 'required|max:255',
            'content' => 'required' 
        ]);

        $form_data = $request->all();
        $new_post = new Post();

        $new_post->fill($form_data);
        //genero lo slug
        $slug = Str::slug($new_post->title, '-');
        $slug_appoggio = $slug;
        //controllo se lo slug è unico
        $post_check = Post::where('slug', $slug)->first();
        $contatore = 1;
        //ciclo per creare uno slug univoco
        while($post_check) {
            //creo il nuovo slug aggiungendo il contatore alla fine
            $slug = $slug_appoggio . '-' . $contatore;
            $contatore++;
            $post_check =  Post::where('slug'. $slug)->first();
        }
        //uscito dal ciclo ho uno slug unico che viene caricato nel db
        $new_post->slug = $slug;

        $new_post->user_id = Auth::id();

        $new_post->save();
        
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if(!$post) {
            abort(404);
        }

        $data = [
            'post' => $post
        ];

        return view('admin.posts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|unique:posts|max:255',
            'content' => 'required' 
        ]);

        $form_data = $request->all();

        //verifico se il titolo è diverso dal vecchio
        if($form_data['title'] != $post->title) {
            
            //genero lo slug
            $slug = Str::slug($form_data['title']);
            $slug_appoggio = $slug;
            //controllo se lo slug è unico
            $post_check = Post::where('slug', $slug)->first();
            $contatore = 1;
            //ciclo per creare uno slug univoco
            while($post_check) {
                //creo il nuovo slug aggiungendo il contatore alla fine
                $slug = $slug_appoggio . '-' . $contatore;
                $contatore++;
                $post_check =  Post::where('slug'. $slug)->first();
            }
            //uscito dal ciclo ho uno slug unico che viene caricato nel db
            $form_data['slug'] = $slug;
        }

        $post->update($form_data);
        
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post -> delete();
        return redirect()->route('posts.index');
    }
}
