@extends('layouts.admin')

@section('title', 'Create Article')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Create Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">Create</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <form action="{{ route('admin.articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
            @csrf
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
                                       value="{{ old('title') }}"
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
                                       value="{{ old('slug') }}"
                                       placeholder="Auto-generated from title...">
                                @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="excerpt">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                          id="excerpt"
                                          name="excerpt"
                                          rows="3"
                                          placeholder="Brief description of the article">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          name="content"
                                          rows="15"
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <select class="form-control select2 @error('tags') is-invalid @enderror"
                                        id="tags"
                                        name="tags[]"
                                        multiple="multiple"
                                        data-placeholder="Select or create tags">
                                    @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
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
                        <div class="card-header">
                            <h3 class="card-title">Publish Settings</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                        id="category_id"
                                        name="category_id"
                                        required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                <input type="datetime-local"
                                       class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at"
                                       name="published_at"
                                       value="{{ old('published_at') }}">
                                @error('published_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Leave empty to publish immediately</small>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Featured Image</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('featured_image') is-invalid @enderror"
                                           id="featured_image"
                                           name="featured_image"
                                           accept="image/jpeg,image/png,image/gif,image/webp">
                                    <label class="custom-file-label" for="featured_image">Choose image</label>
                                </div>
                                @error('featured_image')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title"><i class="fas fa-image"></i> Image Preview</h3>
                                    </div>
                                    <div class="card-body text-center">
                                        <img id="preview" src="#" alt="Image Preview" class="img-fluid img-thumbnail" style="max-height: 250px;">
                                        <div id="imageDetails" class="small text-muted mt-2"></div>
                                        <button type="button" class="btn btn-sm btn-danger mt-2" id="removeImageBtn">
                                            <i class="fas fa-trash"></i> Remove Image
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <div>
                                    <button type="submit" name="action" value="save" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save
                                    </button>
                                    <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                                        <i class="fas fa-check"></i> Save & Continue
                                    </button>
                                </div>
                            </div>
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
    // ===================================

    // Initialize Select2 for tags
    $('#tags').select2({
        theme: 'bootstrap4',
        tags: true,
        tokenSeparators: [','],
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term,
                newTag: true
            };
        }
    });

    // Initialize Summernote WYSIWYG editor
    $('#content').summernote({
        height: 400,
        placeholder: 'Write your article content here...',
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['fontname', ['fontname']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        callbacks: {
            onImageUpload: function(files) {
                // Handle image upload inside Summernote
                for (let i = 0; i < files.length; i++) {
                    uploadSummernoteImage(files[i]);
                }
            }
        }
    });

    // 2. Event Listeners
    // ===================================

    // Auto-generate slug when typing in the title field
    $('#title').on('input keyup paste', function() {
        setTimeout(() => { // Use timeout for paste event
            $('#slug').val(generateSlug($(this).val()));
        }, 10);
    });

    // Handle Featured Image selection and preview
    $('#featured_image').on('change', function() {
        previewImage(this);
    });

    // Handle Remove Image button click
    $('#removeImageBtn').on('click', function() {
        removeImage();
    });

    // Simple form validation for summernote
    $('#articleForm').on('submit', function(e) {
        if ($('#content').summernote('isEmpty')) {
            e.preventDefault();
            alert('Article content cannot be empty.');
        }
    });

    // 3. Helper Functions
    // ===================================

    /**
     * Generates a URL-friendly slug from a string.
     */
    function generateSlug(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '');            // Trim - from end of text
    }

    /**
     * Uploads an image to the server for Summernote editor.
     */
    function uploadSummernoteImage(file) {
        let data = new FormData();
        data.append("file", file);
        data.append("_token", "{{ csrf_token() }}");

        $.ajax({
            url: "{{ route('admin.articles.upload-image') }}",
            type: "POST",
            data: data,
            contentType: false,
            processData: false,
            cache: false,
            success: function(response) {
                if(response.url) {
                    $('#content').summernote('insertImage', response.url);
                }
            },
            error: function(data) {
                console.error('Image upload error:', data);
                alert('Image upload failed. Please check the console for details.');
            }
        });
    }

    /**
     * Displays a preview of the selected featured image.
     */
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];

            // Client-side validation
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Invalid file type. Please select a JPG, PNG, GIF, or WebP image.');
                removeImage();
                return;
            }
            const maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert('File is too large. Maximum size is 5MB.');
                removeImage();
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                $('#imagePreview').show();

                // Update label
                $('.custom-file-label').text(file.name);

                // Get dimensions and display details
                const img = new Image();
                img.onload = function() {
                    $('#imageDetails').html(
                        `<strong>File:</strong> ${file.name}<br>` +
                        `<strong>Size:</strong> ${formatFileSize(file.size)}<br>` +
                        `<strong>Dimensions:</strong> ${this.width} x ${this.height}px`
                    );
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    /**
     * Resets the featured image input and hides the preview.
     */
    function removeImage() {
        $('#featured_image').val('');
        $('.custom-file-label').text('Choose image');
        $('#preview').attr('src', '#');
        $('#imagePreview').hide();
        $('#imageDetails').html('');
    }

    /**
     * Formats file size in bytes to a readable format (KB, MB).
     */
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }
});
</script>
@endpush
