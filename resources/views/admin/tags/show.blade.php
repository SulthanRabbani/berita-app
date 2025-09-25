@extends('layouts.admin')

@section('title', 'Tag Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Tag Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                    <li class="breadcrumb-item active">{{ $tag->name }}</li>
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
                        <div class="card-tools">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Tag
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name:</strong>
                                <p class="text-muted">{{ $tag->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Slug:</strong>
                                <p class="text-muted"><code>{{ $tag->slug }}</code></p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Articles Count:</strong>
                                <p class="text-muted">
                                    <span class="badge badge-info">{{ $tag->articles()->count() }}</span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>Created At:</strong>
                                <p class="text-muted">{{ $tag->created_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <strong>Last Updated:</strong>
                                <p class="text-muted">{{ $tag->updated_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                @if($tag->articles->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Articles with This Tag</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Author</th>
                                        <th>Published At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tag->articles as $article)
                                    <tr>
                                        <td>
                                            <strong>{{ $article->title }}</strong>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $article->status === 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($article->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $article->user->name }}</td>
                                        <td>
                                            {{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.articles.show', $article) }}"
                                               class="btn btn-info btn-sm" title="View Article">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.articles.edit', $article) }}"
                                               class="btn btn-warning btn-sm" title="Edit Article">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @else
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h4>No Articles Found</h4>
                        <p class="text-muted">This tag is not associated with any articles yet.</p>
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create Article
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Edit Tag
                            </a>
                            <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to Tags
                            </a>
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this tag? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="fas fa-trash"></i> Delete Tag
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fas fa-newspaper"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Articles</span>
                                <span class="info-box-number">{{ $tag->articles()->count() }}</span>
                            </div>
                        </div>

                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fas fa-check-circle"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Published</span>
                                <span class="info-box-number">{{ $tag->publishedArticles()->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
