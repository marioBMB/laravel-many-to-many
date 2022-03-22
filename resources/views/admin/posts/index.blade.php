@extends('layouts.admin')

@section('title', 'Boolpress - Tutti i post')

@section('content')

<div class="container col-10">

    <div class="row justify-content-center">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Tutti i posts</h1>
                <a href="{{route("admin.posts.create")}}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Crea nuovo post</a>

            </div>
        </div>
    <div>

    <table class="table">
        <thead class='text-center'>
        <tr>
            <th scope="row">ID</th>
            <th scope="col">Titolo</th>
            {{-- <th scope="col">Anteprima</th> --}}
            <th scope="col">Slug</th>
            <th scope="col">Categoria</th>
            <th scope="col">Pubblicato</th>
            <th scope="col">Data creazione</th>
            <th scope="col">Ultima modifica</th>
            <th scope="col">Tags</th>
            <th scope="col">Azioni</th>
        </tr>
        </thead>
        <tbody>
            @foreach ($posts as $post)
            <tr class='text-center'>
                <td scope="row">{{$post->id}}</td>
                <td>{{$post->title}}</td>
                {{-- <td><span class='d-inline-block text-truncate' style='max-width: 150px'>{{substr($post->content, 0, 30)}}</span></th> --}}
                <td>{{$post->slug}}</td>
                <td>{{$post->category? $post->category->name : "-"}}</td>
                    {{-- è $post->category? e non $post->category->name? perché se non può accedere a category non può neanche a name è come fosse $post->category (), metodo dell'oggetto di classe Post --}}
                <td>{{$post->published? "sì": "no"}}</td>
                <td>{{$post->created_at}}</td>
                <td>{{$post->updated_at}}</td>
                
                <td>
                @foreach ($post->tags as $tag)
                {{$tag ? $tag->name : "-" }}
                @endforeach
                </td>

                <td>
                    <div class="row">
                        <div class="col p-1">
                            <a href="{{route("admin.posts.show", $post->slug)}}">
                                <button type="button" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <div class="col p-1">
                            <a href="{{route("admin.posts.edit", $post->id)}}">
                                <button type="button" class="btn btn-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                    </svg>
                                </button>
                            </a>
                        </div>
                        <div class="col p-1">
                            <form action="{{route("admin.posts.destroy", $post->id)}}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button onclick="return confirm('Sei sicuro di voler cancellare questo post?');" type="submit" class="btn btn-danger text-dark">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        
        </tbody>
    </table>
</div>
@endsection
