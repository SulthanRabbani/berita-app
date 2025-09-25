@extends('layouts.admin')

@section('title', 'Edit Article')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Edit Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Article Content</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $article->title) }}"
                                       placeholder="Enter article title"
                                       required>
                                @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $article->slug) }}"
                                       placeholder="Auto-generated from title...">
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3" placeholder="Brief description">{{ old('excerpt', $article->excerpt) }}</textarea>
                                @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" required>{{ old('content', $article->content) }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                             <div class="form-group">
                                <label for="tags">Tags</label>
                                <select class="form-control select2 @error('tags') is-invalid @enderror" id="tags" name="tags[]" multiple="multiple" data-placeholder="Select or create tags">
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', $article->tags->pluck('id')->toArray())) ? 'selected' : '' }}>
                                            {{ $tag->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Publish Settings</h3></div>
                        <div class="card-body">
                             <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="status" name="status">
                                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id', $article->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="published_at">Publish Date</label>
                                <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Featured Image</h3></div>
                        <div class="card-body">
                            @if($article->featured_image)
                                <div class="mb-3 text-center">
                                    <p class="mb-2"><strong>Current Image:</strong></p>

                                    <img src="{{ $article->featured_image_url }}" alt="Current Image" class="img-fluid img-thumbnail" style="max-height: 150px;">
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                        <label class="form-check-label text-danger" for="remove_image">
                                            <i class="fas fa-trash"></i> Remove current image
                                        </label>
                                    </div>
                                </div>
                                <hr>
                            @endif

                            <div class="form-group" id="imageUploadGroup">
                                <label for="featured_image">{{ $article->featured_image ? 'Replace Image' : 'Upload Image' }}</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('featured_image') is-invalid @enderror" id="featured_image" name="featured_image" accept="image/*">
                                    <label class="custom-file-label" for="featured_image">Choose image</label>
                                </div>
                                @error('featured_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imagePreview" class="mt-3 text-center" style="display: none;">
                                <p class="mb-2"><strong>New Image Preview:</strong></p>
                                <img id="preview" src="#" alt="New Image Preview" class="img-fluid img-thumbnail" style="max-height: 150px;">
                                <div id="imageDetails" class="small text-muted mt-2"></div>
                                <button type="button" class="btn btn-sm btn-danger mt-2" id="removePreviewBtn">
                                    <i class="fas fa-times"></i> Cancel Upload
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Article
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>

    <script>
    $(document).ready(function() {

        // 1. Initialize Plugins
        $('#tags').select2({ theme: 'bootstrap4', tags: true });
        $('#content').summernote({
            height: 400,
            placeholder: 'Write your article content here...',
            // (toolbar settings can be added here if needed)
        });

        // 2. Event Listeners
        $('#title').on('input', () => $('#slug').val(generateSlug($('#title').val())));
        $('#featured_image').on('change', function() { previewImage(this); });
        $('#removePreviewBtn').on('click', () => removeImagePreview());
        $('#remove_image').on('change', function() {
            $('#imageUploadGroup').toggle(!this.checked);
            if (this.checked) {
                removeImagePreview();
            }
        });

        // 3. Helper Functions
        const generateSlug = text => text.toString().toLowerCase()
            .replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');

        const previewImage = input => {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                // (Optional: add file type/size validation here)
                const reader = new FileReader();
                reader.onload = e => {
                    $('#preview').attr('src', e.target.result);
                    $('#imagePreview').show();
                    $('.custom-file-label').text(file.name);
                    const img = new Image();
                    img.onload = function() {
                        $('#imageDetails').html(
                            `<strong>Size:</strong> ${Math.round(file.size / 1024)} KB | ` +
                            `<strong>Dimensions:</strong> ${this.width} x ${this.height}px`
                        );
                    };
                    img.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        };

        const removeImagePreview = () => {
            $('#featured_image').val('');
            $('.custom-file-label').text('Choose image');
            $('#imagePreview').hide();
            $('#preview').attr('src', '#');
        };
    });
    </script>
@endpush
