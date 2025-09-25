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
                            <!-- Title -->
                            <div class="form-group">
                                <label for="title">Title <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $article->title) }}"
                                       placeholder="Enter article title"
                                       oninput="generateSlug(this.value)"
                                       onpaste="setTimeout(function(){ generateSlug(document.getElementById('title').value); }, 10)"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $article->slug) }}"
                                       placeholder="Will be auto-generated from title...">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Auto-generated from title or enter custom slug</small>
                            </div>

                            <!-- Excerpt -->
                            <div class="form-group">
                                <label for="excerpt">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                          id="excerpt"
                                          name="excerpt"
                                          rows="3"
                                          placeholder="Brief description of the article">{{ old('excerpt', $article->excerpt) }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="form-group">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          name="content"
                                          rows="15"
                                          required>{{ old('content', $article->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Tags -->
                            <div class="form-group">
                                <label for="tags">Tags</label>
                                <select class="form-control select2 @error('tags') is-invalid @enderror"
                                        id="tags"
                                        name="tags[]"
                                        multiple="multiple"
                                        data-placeholder="Select or create tags">
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
                    <!-- Publish Settings -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publish Settings</h3>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="draft" {{ old('status', $article->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $article->status) === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('status', $article->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category -->
                            <div class="form-group">
                                <label for="category_id">Category <span class="text-danger">*</span></label>
                                <select class="form-control @error('category_id') is-invalid @enderror"
                                        id="category_id"
                                        name="category_id"
                                        required>
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

                            <!-- Published At -->
                            <div class="form-group">
                                <label for="published_at">Publish Date</label>
                                <input type="datetime-local"
                                       class="form-control @error('published_at') is-invalid @enderror"
                                       id="published_at"
                                       name="published_at"
                                       value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d\TH:i') : '') }}">
                                @error('published_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Leave empty to publish immediately</small>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Featured Image</h3>
                        </div>
                        <div class="card-body">
                            @if($article->featured_image)
                                <div class="current-image mb-3">
                                    <div class="card card-outline card-success">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                <i class="fas fa-image"></i> Current Image
                                            </h3>
                                        </div>
                                        <div class="card-body text-center">
                                            <img src="{{ $article->featured_image_url }}"
                                                 alt="Current Featured Image"
                                                 class="img-fluid img-thumbnail"
                                                 style="max-height: 250px; width: auto;">
                                            <div class="mt-2">
                                                <div class="small text-muted">
                                                    <div><strong>File Path:</strong> {{ basename($article->featured_image) }}</div>
                                                </div>
                                            </div>
                                            <div class="form-check mt-3">
                                                <input class="form-check-input" type="checkbox" id="remove_image" name="remove_image" value="1">
                                                <label class="form-check-label text-danger" for="remove_image">
                                                    <i class="fas fa-trash"></i> Remove current image
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="featured_image">{{ $article->featured_image ? 'Replace with new image' : 'Upload featured image' }}</label>
                                <div class="custom-file">
                                    <input type="file"
                                           class="custom-file-input @error('featured_image') is-invalid @enderror"
                                           id="featured_image"
                                           name="featured_image"
                                           accept="image/*"
                                           onchange="previewImage(this)">
                                    <label class="custom-file-label" for="featured_image">Choose image</label>
                                </div>
                                @error('featured_image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div id="imagePreview" class="mt-3" style="display: none;">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card card-outline card-info">
                                            <div class="card-header">
                                                <h3 class="card-title">
                                                    <i class="fas fa-image"></i> New Image Preview
                                                </h3>
                                            </div>
                                            <div class="card-body text-center">
                                                <img id="preview" src="#" alt="Image Preview" class="img-fluid img-thumbnail" style="max-height: 250px; width: auto;">
                                                <div class="mt-2">
                                                    <div id="imageDetails" class="small text-muted">
                                                        <div><strong>File Name:</strong> <span id="fileName"></span></div>
                                                        <div><strong>File Size:</strong> <span id="fileSize"></span></div>
                                                        <div><strong>Dimensions:</strong> <span id="imageDimensions"></span></div>
                                                        <div><strong>File Type:</strong> <span id="fileType"></span></div>
                                                    </div>
                                                </div>
                                                <div class="mt-2">
                                                    <button type="button" class="btn btn-sm btn-danger" onclick="removeImage()">
                                                        <i class="fas fa-trash"></i> Remove New Image
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Article Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Article Info</h3>
                        </div>
                        <div class="card-body">
                            <p class="mb-1"><strong>Author:</strong> {{ $article->user->name }}</p>
                            <p class="mb-1"><strong>Created:</strong> {{ $article->created_at->format('M d, Y H:i') }}</p>
                            <p class="mb-1"><strong>Updated:</strong> {{ $article->updated_at->format('M d, Y H:i') }}</p>
                            <p class="mb-0"><strong>Views:</strong> {{ number_format($article->views_count) }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                                <div>
                                    <button type="submit" name="action" value="save" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update
                                    </button>
                                    <button type="submit" name="action" value="save_and_continue" class="btn btn-success">
                                        <i class="fas fa-save"></i> Update & Continue
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

<!-- Global JavaScript untuk slug generation dan image preview -->
<script>
    // Auto-generate slug from title
    function generateSlug(titleValue) {
        var slugField = document.getElementById('slug');
        if (slugField) {
            var slug = titleValue
                .toLowerCase()
                .replace(/[^a-z0-9\s]+/gi, '') // Remove special chars but keep spaces
                .replace(/\s+/g, '-') // Replace spaces with hyphens
                .replace(/-+/g, '-') // Replace multiple hyphens
                .replace(/^-|-$/g, ''); // Remove leading/trailing hyphens

            slugField.value = slug;

            // Visual feedback
            if (slug) {
                slugField.style.borderColor = '#28a745';
                slugField.style.backgroundColor = '#f8f9fa';
            }
        }
    }

    // Image preview function with detailed information
    function previewImage(input) {
        console.log('previewImage called'); // Debug log

        if (input.files && input.files[0]) {
            const file = input.files[0];
            const reader = new FileReader();

            console.log('File selected:', file.name, file.type, file.size); // Debug log

            // Validate file type
            const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowedTypes.includes(file.type)) {
                alert('Please select a valid image file (JPEG, PNG, GIF, WebP)');
                removeImage();
                return;
            }

            // Validate file size (5MB max)
            const maxSize = 5 * 1024 * 1024; // 5MB in bytes
            if (file.size > maxSize) {
                alert('File size must be less than 5MB');
                removeImage();
                return;
            }

            reader.onload = function(e) {
                console.log('File loaded successfully'); // Debug log

                // Show preview image
                const previewElement = document.getElementById('preview');
                const imagePreviewElement = document.getElementById('imagePreview');

                if (previewElement && imagePreviewElement) {
                    previewElement.src = e.target.result;
                    imagePreviewElement.style.display = 'block';

                    // Display file information
                    const fileNameElement = document.getElementById('fileName');
                    const fileSizeElement = document.getElementById('fileSize');
                    const fileTypeElement = document.getElementById('fileType');

                    if (fileNameElement) fileNameElement.textContent = file.name;
                    if (fileSizeElement) fileSizeElement.textContent = formatFileSize(file.size);
                    if (fileTypeElement) fileTypeElement.textContent = file.type;

                    // Get image dimensions
                    const img = new Image();
                    img.onload = function() {
                        const dimensionsElement = document.getElementById('imageDimensions');
                        if (dimensionsElement) {
                            dimensionsElement.textContent = this.width + ' × ' + this.height + ' pixels';
                        }
                    };
                    img.src = e.target.result;

                    // Visual feedback for file input
                    const customLabel = document.querySelector('.custom-file-label');
                    if (customLabel) {
                        customLabel.textContent = file.name;
                        customLabel.classList.add('selected');
                    }
                }
            };

            reader.readAsDataURL(file);
        }
    }

    // Format file size
    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    // Remove image function
    function removeImage() {
        const imagePreviewElement = document.getElementById('imagePreview');
        const featuredImageElement = document.getElementById('featured_image');
        const customLabel = document.querySelector('.custom-file-label');
        const previewElement = document.getElementById('preview');

        if (imagePreviewElement) imagePreviewElement.style.display = 'none';
        if (featuredImageElement) featuredImageElement.value = '';
        if (customLabel) {
            customLabel.textContent = 'Choose image';
            customLabel.classList.remove('selected');
        }
        if (previewElement) previewElement.src = '#';

        // Clear all detail fields
        ['fileName', 'fileSize', 'fileType', 'imageDimensions'].forEach(id => {
            const element = document.getElementById(id);
            if (element) element.textContent = '';
        });
    }
</script>

<!-- Global JavaScript untuk slug generation -->
<script>
    // Auto-generate slug from title
    function generateSlug(titleValue) {
        var slugField = document.getElementById('slug');
        if (slugField) {
            var slug = titleValue
                .toLowerCase()
                .replace(/[^a-z0-9\s]+/gi, '')  // Remove special chars but keep spaces
                .replace(/\s+/g, '-')           // Replace spaces with hyphens
                .replace(/-+/g, '-')            // Replace multiple hyphens
                .replace(/^-|-$/g, '');         // Remove leading/trailing hyphens

            slugField.value = slug;

            // Visual feedback
            if (slug) {
                slugField.style.borderColor = '#28a745';
                slugField.style.backgroundColor = '#f8f9fa';
            }
        }
    }
</script>

@push('styles')
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@x.x.x/dist/select2-bootstrap4.min.css">

    <!-- Summernote CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.css">
@endpush

@push('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Summernote JS -->
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-bs4.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2 for tags
            $('#tags').select2({
                theme: 'bootstrap4',
                tags: true,
                tokenSeparators: [','],
                createTag: function (params) {
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
                        // Handle image upload
                        for (let i = 0; i < files.length; i++) {
                            uploadImage(files[i]);
                        }
                    }
                }
            });

            // Custom file input label update
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });
        });

        // Upload image for Summernote
        function uploadImage(file) {
            let data = new FormData();
            data.append("file", file);
            data.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.articles.upload-image') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    $('#content').summernote('insertImage', response.url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        // Form validation
        $(document).ready(function() {
            $('#articleForm').on('submit', function(e) {
                let content = $('#content').summernote('code');
                if (content === '<p><br></p>' || content === '') {
                    e.preventDefault();
                    alert('Please add some content to your article.');
                    return false;
                }
            });
        });

        // Upload image for Summernote
        function uploadImage(file) {
            let data = new FormData();
            data.append("file", file);
            data.append("_token", "{{ csrf_token() }}");

            $.ajax({
                url: "{{ route('admin.articles.upload-image') }}",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                success: function(response) {
                    $('#content').summernote('insertImage', response.url);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        // Form validation
        $(document).ready(function() {
            $('#articleForm').on('submit', function(e) {
                let content = $('#content').summernote('code');
                if (content === '<p><br></p>' || content === '') {
                    e.preventDefault();
                    alert('Please add some content to your article.');
                    return false;
                }
            });
        });
    </script>
@endpush
