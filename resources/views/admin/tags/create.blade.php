@extends('layouts.admin')

@section('title', 'Create Tag')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Create Tag</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                    <li class="breadcrumb-item active">Create</li>
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
                        <h3 class="card-title">Tag Information</h3>
                    </div>

                    <form action="{{ route('admin.tags.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Enter tag name"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">The name will be used as the display name for this tag.</small>
                            </div>

                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text"
                                       class="form-control @error('slug') is-invalid @enderror"
                                       id="slug"
                                       name="slug"
                                       value="{{ old('slug') }}"
                                       placeholder="Enter tag slug (optional)">
                                @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">URL-friendly version of the name. Leave empty to auto-generate from name.</small>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Tag
                            </button>
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Tags
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Help</h3>
                    </div>
                    <div class="card-body">
                        <h5>Tag Guidelines</h5>
                        <ul class="list-unstyled">
                            <li><i class="fas fa-info-circle text-info"></i> Tags help organize articles by topics</li>
                            <li><i class="fas fa-info-circle text-info"></i> Keep tag names short and descriptive</li>
                            <li><i class="fas fa-info-circle text-info"></i> Use lowercase for consistency</li>
                            <li><i class="fas fa-info-circle text-info"></i> Avoid special characters in tag names</li>
                        </ul>

                        <h5 class="mt-3">Slug</h5>
                        <p class="text-muted">
                            The slug is used in URLs and should be URL-friendly.
                            If left empty, it will be automatically generated from the tag name.
                        </p>
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
    // Auto-generate slug from name
    $('#name').on('input', function() {
        let name = $(this).val();
        let slug = name.toLowerCase()
            .replace(/[^a-z0-9\s-]/g, '') // Remove invalid chars
            .replace(/\s+/g, '-') // Replace spaces with -
            .replace(/-+/g, '-') // Replace multiple - with single -
            .trim('-'); // Trim - from start and end
        $('#slug').val(slug);
    });
});
</script>
@endpush
