@extends('layouts.app')

@section('content')
    <div class="p-3">
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}
        <form id="form"
            action="{{ Route::currentRouteNamed('posts.create') ? route('posts.store') : route('posts.update', isset($item) ? $item->id : 0) }}"
            method="POST">
            @csrf
            @method(Route::currentRouteNamed('posts.create') ? 'POST' : 'PATCH')
            @if (Route::currentRouteNamed('posts.create'))
                <h1>Add A New Student</h1>
            @else
                <h1>Edit Student: {{ isset($item) ? $item->name : '' }}</h1>
            @endif
            <div class="modal-body">
                <div class="form-group">
                    <label for="title">Name</label>
                    <input type="text" class="form-control" id="title" name="title" placeholder="Post Title"
                        value="{{ isset($item) ? old('title') ?? $item->title : old('title') }}">
                    @error('title')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="slug" class="form-control" id="slug" name="slug" placeholder="post-title"
                        value="{{ isset($item) ? old('slug') ?? $item->slug : old('slug') }}">
                    @error('slug')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="content">Content</label>
                    <textarea></textarea>
                    <textarea name="content" id="content"></textarea>
                    @error('content')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('posts.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">
                    @if (Route::currentRouteNamed('posts.create'))
                        Create
                    @else
                        Save
                    @endif
                </button>
            </div>
        </form>
    </div>
@endsection

@push('head')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
@endpush

@push('script')
    <script>
      const easyMDE = new EasyMDE()
        document.addEventListener('DOMContentLoaded', function() {
            easyMDE.value('{{$item->content}}')
        });
    </script>

    <script>
        const slugify = (str) => {
            return str
                .toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '') // Remove unwanted characters
                .replace(/\s+/g, '-') // Replace spaces with dashes
                .replace(/-+/g, '-'); // Remove consecutive dashes
        }
    </script>

    <script>
        easyMDE.codemirror.on("change", () => {
            document.querySelector('textarea#content').value = easyMDE.value()
        })

        document.querySelector('#title').addEventListener('keyup', (e) => {
            document.querySelector('#slug').value = slugify(e.target.value)
        })
    </script>
@endpush
