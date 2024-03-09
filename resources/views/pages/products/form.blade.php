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
            action="{{ Route::currentRouteNamed('products.create') ? route('products.store') : route('products.update', isset($item) ? $item->id : 0) }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method(Route::currentRouteNamed('products.create') ? 'POST' : 'PATCH')
            @if (Route::currentRouteNamed('products.create'))
                <h1>Add A New Product</h1>
            @else
                <h1>Edit Product: {{ isset($item) ? $item->name : '' }}</h1>
            @endif
            <div class="modal-body">
                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select class="custom-select" name="category_id" id="category_id">
                        <option value="" selected>Select category...</option>
                        @foreach ($categories as $c)
                            <option value="{{ $c->id }}" @selected($c->id==$item->category_id)>{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <!-- <input type="text" class="form-control" id="category_id" name="category_id" placeholder="Product Name"
                                                value="{{ isset($item) ? old('category_id') ?? $item->category_id : old('category_id') }}"> -->
                    @error('category_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Product Name"
                        value="{{ isset($item) ? old('name') ?? $item->name : old('name') }}">
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="slug">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" placeholder="post-title"
                        value="{{ isset($item) ? old('slug') ?? $item->slug : old('slug') }}">
                    @error('slug')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="price">Price</label>
                    <input type="number" class="form-control" id="price" name="price" placeholder="Rp. XXXXXX"
                        value="{{ isset($item) ? old('price') ?? $item->price : old('price') }}">
                    @error('price')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="images">Images</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="images" name="images[]" multiple
                            accept="image/*" onchange="previewImages()">
                        <label class="custom-file-label" for="images">Choose file</label>
                    </div>
                    <div id="imagePreview"></div>
                    @error('images')
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
                <a class="btn btn-secondary" href="{{ route('products.index') }}">Cancel</a>
                <button class="btn btn-primary" type="submit">
                    @if (Route::currentRouteNamed('products.create'))
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

    <style>
        #imagePreview {
            display: flex;
            flex-wrap: wrap;
        }

        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin: 5px;
        }
    </style>
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

    <script>
        const oldImages = {!! json_encode(isset($item) ? $item->images : []) !!};
        const previewContainer = document.getElementById('imagePreview');

        function previewImages() {
            var files = document.getElementById('images').files;
            var imagesToPreview = oldImages.slice(); // Copy oldImages to avoid modifying it directly

            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                var reader = new FileReader();

                reader.onload = function(e) {
                    var imgElement = document.createElement('img');
                    imgElement.className = 'preview-image';
                    imgElement.src = e.target.result;

                    imagesToPreview.push(e.target.result); // Add new image to the array
                    previewContainer.appendChild(imgElement);
                };

                reader.readAsDataURL(file);
            }

            updatePreview(imagesToPreview);
        }

        function updatePreview(images) {
            previewContainer.innerHTML = '';

            for (var i = 0; i < images.length; i++) {
                var imgElement = document.createElement('img');
                imgElement.className = 'preview-image';
                imgElement.src = images[i];
                if (oldImages.includes(images[i])){
                  imgElement.classList.add('brightness-50')
                }

                previewContainer.appendChild(imgElement);
            }
        }

        // Initial preview for old images
        updatePreview(oldImages);
    </script>
@endpush
