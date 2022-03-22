<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Category;
use App\Tag;
use App\Post;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected function slug($title, $idToExclude=""){
        $tmp = Str::slug($title);
        $count = 1;
        while(Post::where('slug', $tmp)
        -> where('id', '!=', $idToExclude) /* stesso ruolo del validate unique */
        -> first()){
            $tmp = Str::slug($title). "-" . $count;
            $count++;
        }
        return $tmp;
    }

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
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $request->validate([
            'title' => "required|string|between:5,255",
            'content' => "required|string",
            'published' => "required|boolean",
            'category_id'=> "nullable|exists:categories,id",
            'image' => "nullable|image|mimes:jpg,bmp,png|max:2048",
            // 'thumb' => "nullable|url",
        ]);

        $form_data = $request->all();

        if (isset($form_data['image'])){
            $img_path = Storage::put('uploads', $form_data['image']);
            $form_data['image'] = $img_path;
        }

        $form_data['slug'] = $this->slug($form_data['title']);

         /* lo store ha una gestione diversa dall'update: qui devo solo scrivere ex-novo, non cancellare eventualmente qualcosa di preesistente */
        if (isset($form_data['tags'])){
            $new_post->tags()->sync($form_data['tags']);
        }
        $newPost = new Post();
        $newPost = Post::create($form_data);

        return redirect()->route('admin.posts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($post) 
    {   
        $post = Post::where('slug', $post)->first();
        if (!$post){
            abort(404);
        }
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
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
            'title' => "required|string|between:5,255",
            'content' => "required|string",
            'published' => "required|boolean",
            'category_id'=> "nullable|exists:categories,id",
            'image' => "nullable|image|mimes:jpg,bmp,png|max:2048",
            // 'thumb' => "nullable|url",
        ]);
        $form_data = $request->all();
        
        if (isset($form_data['image'])){
            $img_path = Storage::put('uploads', $form_data['image']);
            $form_data['image'] = $img_path; //sovrascrittura
        }
        /* va ricalcolato lo slug solo se cambia il titolo */
        $form_data['slug'] = ($post->title == $form_data['title']) ? $post->slug : $this->slug($form_data['title'], $post->id);
        
        $post->tags()->sync(isset($form_data['tags']) ? $form_data['tags']:[]);
        /* 
        se l'utente ha selezionato almeno un tag, scrive nella tabella pivot i tag scelti, altrimenti va a svuotare la tabella pivot.
        impostare un array vuoto come argomento della sync è come se facesse un detach() senza argomenti, quindi svuota la pivot.
        Perché dobbiamo fare così? Perché $form_data['tags'], se l'utente non ha selezionato nemmeno un tag, è undefined.
        */

        $post->update($form_data);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
