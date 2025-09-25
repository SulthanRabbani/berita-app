@extends('layouts.admin')

@section('title', 'Category: ' . $category->name)

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Category: {{ $category->name }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="breadcrumb-item active">{{ $category->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <!-- Category Info -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Category Information</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name:</strong>
                                <p class="text-muted">{{ $category->name }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Slug:</strong>
                                <p class="text-muted">
                                    <code>{{ $category->slug }}</code>
                                    <a href="{{ route('category.show', $category) }}" target="_blank" class="btn btn-xs btn-outline-primary ml-2">
                                        <i class="fas fa-external-link-alt"></i> View Public
                                    </a>
                                </p>
                            </div>
                        </div>

                        @if($category->description)
                        <div class="row">
                            <div class="col-12">
                                <strong>Description:</strong>
                                <p class="text-muted">{{ $category->description }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <strong>Created:</strong>
                                <p class="text-muted">{{ $category->created_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Last Updated:</strong>
                                <p class="text-muted">{{ $category->updated_at->format('M d, Y \a\t H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Articles in Category -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Articles in this Category</h3>
                        <div class="card-tools">
                            <span class="badge badge-info">{{ $category->articles->count() }} total</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($category->articles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($category->articles as $article)
                                        <tr>
                                            <td>
                                                <strong>{{ $article->title }}</strong>
                                                @if($article->featured_image)
                                                    <i class="fas fa-image text-muted ml-1"></i>
                                                @endif
                                            </td>
                                            <td>{{ $article->user->name }}</td>
                                            <td>
                                                @if($article->status === 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @elseif($article->status === 'draft')
                                                    <span class="badge badge-secondary">Draft</span>
                                                @else
                                                    <span class="badge badge-warning">{{ ucfirst($article->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->created_at->format('M d, Y') }}</td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    @if(Route::has('admin.articles.show'))
                                                        <a href="{{ route('admin.articles.show', $article) }}" class="btn btn-info" title="View">
                                                            <i class="fas fa-eye"></i>
                                                        </a>
                                                    @endif
                                                    @if(Route::has('admin.articles.edit'))
                                                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if($article->status === 'published')
                                                        <a href="{{ route('article.show', $article) }}" target="_blank" class="btn btn-success" title="View Public">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            @if($category->articles()->count() > 10)
                                <div class="text-center mt-3">
                                    <p class="text-muted">Showing latest 10 articles.</p>
                                    @if(Route::has('admin.articles.index'))
                                        <a href="{{ route('admin.articles.index') }}?category={{ $category->slug }}" class="btn btn-outline-primary">
                                            View All Articles in this Category
                                        </a>
                                    @endif
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                                <h5>No articles in this category</h5>
                                <p class="text-muted">Articles assigned to this category will appear here.</p>
                                @if(Route::has('admin.articles.create'))
                                    <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus"></i> Create Article
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <!-- Category Stats -->
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

                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fas fa-edit"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Drafts</span>
                                <span class="info-box-number">{{ $category->articles()->where('status', 'draft')->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        <div class="btn-group-vertical w-100">
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-warning mb-2">
                                <i class="fas fa-edit"></i> Edit Category
                            </a>
                            <a href="{{ route('category.show', $category) }}" target="_blank" class="btn btn-info mb-2">
                                <i class="fas fa-external-link-alt"></i> View Public Page
                            </a>
                            @if(Route::has('admin.articles.create'))
                                <a href="{{ route('admin.articles.create') }}" class="btn btn-primary mb-2">
                                    <i class="fas fa-plus"></i> Add Article
                                </a>
                            @endif
                            <button type="button" class="btn btn-danger"
                                    onclick="deleteCategory()"
                                    data-articles-count="{{ $category->articles()->count() }}">
                                <i class="fas fa-trash"></i> Delete Category
                            </button>
                        </div>

                        <form id="delete-form" action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function deleteCategory() {
    var button = document.querySelector('[data-articles-count]');
    var articlesCount = parseInt(button.getAttribute('data-articles-count'));

    if (articlesCount > 0) {
        alert('Cannot delete category that has articles. Please move or delete the articles first.');
        return;
    }

    if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
        document.getElementById('delete-form').submit();
    }
}
</script>
@endpush
