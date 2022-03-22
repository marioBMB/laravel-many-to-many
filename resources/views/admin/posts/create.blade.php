@extends('layouts.admin')


@section('content')

    <div class="container">

        <div class='title'>
            <h1>Nuovo post</h1>
        </div>
            
        <form action="{{route('admin.posts.store')}}" method="POST" enctype='multipart/form-data'>
            @csrf    
            
            <div class="form-group">
                <label for="title">Titolo</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                id="title" name="title" placeholder="Inserisci il titolo del post">
                @error('title')
                <div class="alert alert-danger">{{$message}}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="published">Pubblicare?</label>
                <select class="form-control form-control-md" id="published" name="published">
                    <option value="0">Non pubblicare</option>
                    <option value="1">Pubblica</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="content">Testo</label>
                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" placeholder="Inserisci testo del post"></textarea>
            </div>

            <div class="form-group">
                <label for="category_id">Categoria</label>
                <select name="category_id" class="form-control" id="">
                    <option value="">-- seleziona categoria --</option>
                    @foreach ($categories as $category)
                        <option value="{{$category->id}}">
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                {{-- questa gestione degli errori serve poiché potrebbe essere possibile iniettare tramite html dei valori non consentiti come option della select 
                (modificando il DOM) e facendo submit invieremmo dati che il server deve scartare --}}
                @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="image">Immagine</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" placeholder="Inserisci l'url dell'immagine del post">
            </div>
            
            <button type="submit" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i> Crea post</button> 
        </form>

        @if ($errors->any())
        <div class='alert alert-danger'>
            
            <ul>
                @foreach($errors -> all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
@endsection