@extends('layouts.app')

@section('content')
    <div class="p-3">
        <form id="form"
            action="{{ Route::currentRouteNamed('students.create') ? route('students.store') : route('students.update', isset($item) ? $item->id : 0) }}"
            method="POST">
            @csrf
            @method(Route::currentRouteNamed('students.create') ? 'POST' : 'PATCH')
            @if (Route::currentRouteNamed('students.create'))
                <h1>Add A New Student</h1>
            @else
                <h1>Edit Student: {{ isset($item) ? $item->name : '' }}</h1>
            @endif
            <div class="modal-body">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Oalah Siswa"
                        value="{{ isset($item) ? old('name') ?? $item->name : old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com"
                        value="{{ isset($item) ? old('email') ?? $item->email : old('email') }}">
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <span>Favorites (Min: 1, Max: 3)</span>
                    @error('favorites')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="science" id="favoriteScience"
                            name="favorites[]" @checked(isset($item) ? in_array('science', $item->favorites) : false)>
                        <label class="form-check-label" for="favoriteScience">
                            Science
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="computer" id="favoriteComputer"
                            name="favorites[]" @checked(isset($item) ? in_array('computer', $item->favorites) : false)>
                        <label class="form-check-label" for="favoriteComputer">
                            Computer
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="music" id="favoriteMusic" name="favorites[]"
                            @checked(isset($item) ? in_array('music', $item->favorites) : false)>
                        <label class="form-check-label" for="favoriteMusic">
                            Music
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="art" id="favoriteArt" name="favorites[]"
                            @checked(isset($item) ? in_array('art', $item->favorites) : false)>
                        <label class="form-check-label" for="favoriteArt">
                            Art
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="social" id="favoriteSocial"
                            name="favorites[]" @checked(isset($item) ? in_array('social', $item->favorites) : false)>
                        <label class="form-check-label" for="favoriteSocial">
                            Social
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="0" id="favorite0" name="favorites[]"
                            @checked(isset($item) ? in_array('0', $item->favorites) : false)>
                        <label class="form-check-label" for="favorite0">
                            There are no suitable options
                        </label>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary" href="{{ route('students.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">
                  @if (Route::currentRouteNamed('students.create'))
                    Create
                  @else
                    Save
                  @endif
                </button>
            </div>
        </form>
    </div>
@endsection
