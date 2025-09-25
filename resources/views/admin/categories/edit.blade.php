@extends('layouts.admin')

@section('title', 'Edit Category')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Edit Category</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">Edit</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Edit Category: {{ $category->name }}</h3>
                    </div>

                    <form action="{{ route('admin.categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $category->name) }}"
                                       placeholder="Enter category name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">The name will be used as the display name for this category.</small>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug', $category->slug) }}"
                                       placeholder="auto-generated-from-name">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Leave empty to auto-generate from name. Used in URLs.</small>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Optional description for this category.</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Category
                            </button>
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-info">
                                <i class="fas fa-eye"></i> View Category
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category Stats</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-newspaper"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Articles</span>
                                <span class="info-box-number">{{ $category->articles()->count() }}</span>
                            </div>
                        </div>

                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-eye"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Published</span>
                                <span class="info-box-number">{{ $category->publishedArticles()->count() }}</span>
                            </div>
                        </div>

                        <hr>

                        <small class="text-muted">
                            <strong>Created:</strong> {{ $category->created_at->format('M d, Y \a\t H:i') }}<br>
                            <strong>Last Updated:</strong> {{ $category->updated_at->format('M d, Y \a\t H:i') }}
                        </small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Guidelines</h3>
                    </div>
                    <div class="card-body">
                        <h6><i class="fas fa-exclamation-triangle text-warning"></i> Important</h6>
                        <p class="text-muted small">Changing the slug will affect existing URLs. Make sure to update any links if necessary.</p>

                        <h6><i class="fas fa-trash text-danger"></i> Deletion</h6>
                        <p class="text-muted small">Categories with articles cannot be deleted. Move or delete articles first.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let originalSlug = '{{ $category->slug }}';

    // Auto-generate slug from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[^\w\s-]/g, '') // Remove special characters
            .replace(/[\s_-]+/g, '-') // Replace spaces and underscores with dashes
            .replace(/^-+|-+$/g, ''); // Remove leading/trailing dashes

        if ($('#slug').val() === originalSlug || $('#slug').data('auto-generated')) {
            $('#slug').val(slug).data('auto-generated', true);
        }
    });

    // Mark manual input for slug
    $('#slug').on('input', function() {
        $(this).removeData('auto-generated');
    });
});
</script>
@endpush
