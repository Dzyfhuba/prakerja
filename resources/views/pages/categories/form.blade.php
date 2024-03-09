@extends('layouts.app')

@section('content')
    <div class="p-3">
      @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form id="form"
            action="{{ Route::currentRouteNamed('categories.create') ? route('categories.store') : route('categories.update', isset($item) ? $item->id : 0) }}"
            method="POST">
            @csrf
            @method(Route::currentRouteNamed('categories.create') ? 'POST' : 'PATCH')
            @if (Route::currentRouteNamed('categories.create'))
                <h1>Add A New Category</h1>
            @else
                <h1>Edit Category: {{ isset($item) ? $item->name : '' }}</h1>
            @endif
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Category</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Categori A"
                        value="{{ isset($item) ? old('name') ?? $item->name : old('name') }}">
                    @error('name')
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
                    <label for="description">Description</label>
                    <textarea></textarea>
                    <textarea name="description" id="description" hidden></textarea>
                    @error('description')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('categories.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">
                    @if (Route::currentRouteNamed('categories.create'))
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
            easyMDE.value('{{ isset($item) ? $item->description : '' }}')
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
            document.querySelector('textarea#description').value = easyMDE.value()
        })

        document.querySelector('#name').addEventListener('keyup', (e) => {
            document.querySelector('#slug').value = slugify(e.target.value)
        })
    </script>
@endpush
