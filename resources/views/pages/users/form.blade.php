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
            action="{{ Route::currentRouteNamed('users.create') ? route('users.store') : route('users.update', isset($item) ? $item->id : 0) }}"
            method="POST">
            @csrf
            @method(Route::currentRouteNamed('users.create') ? 'POST' : 'PATCH')
            @if (Route::currentRouteNamed('users.create'))
                <h1>Add A New User</h1>
            @else
                <h1>Edit User: {{ isset($item) ? $item->name : '' }}</h1>
            @endif
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                        value="{{ isset($item) ? old('name') ?? $item->name : old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="user@mail.com"
                        value="{{ isset($item) ? old('email') ?? $item->email : old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="roles">Roles</label>
                    @error('roles')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    @foreach ($roles as $role)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$role->name}}" id="{{$role->name}}"
                            name="roles[]" @checked(isset($item) ? in_array($role->name, $item->getRoleNames()->toArray()) : '')>
                        <label class="form-check-label" for="{{$role->name}}">
                            {{$role->name}}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" class="form-control" id="password" name="password" readonly value="12345678"
                        value="{{ isset($item) ? old('password') ?? $item->password : old('password') }}">
                    @error('password')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('users.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">
                    @if (Route::currentRouteNamed('users.create'))
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
