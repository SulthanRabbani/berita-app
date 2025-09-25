@extends('layouts.admin')

@section('title', 'Manage Articles')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Articles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Articles</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">All Articles</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus"></i> Create Article
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="articlesTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Featured Image</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Author</th>
                                        <th>Status</th>
                                        <th>Views</th>
                                        <th>Published At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($articles as $article)
                                        <tr>
                                            <td>{{ $article->id }}</td>
                                            <td>
                                                @if($article->featured_image)
                                                    <img src="{{ Storage::url($article->featured_image) }}"
                                                         alt="Featured Image"
                                                         class="img-thumbnail"
                                                         style="max-width: 80px; max-height: 60px;">
                                                @else
                                                    <span class="text-muted">No Image</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.articles.show', $article) }}" class="text-decoration-none">
                                                    {{ Str::limit($article->title, 30) }}
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ $article->category->name }}</span>
                                            </td>
                                            <td>{{ $article->user->name }}</td>
                                            <td>
                                                @if($article->status === 'published')
                                                    <span class="badge bg-success">Published</span>
                                                @elseif($article->status === 'draft')
                                                    <span class="badge bg-secondary">Draft</span>
                                                @else
                                                    <span class="badge bg-warning">Archived</span>
                                                @endif
                                            </td>
                                            <td>{{ number_format($article->views_count) }}</td>
                                            <td>
                                                @if($article->published_at)
                                                    {{ $article->published_at->format('M d, Y') }}
                                                @else
                                                    <span class="text-muted">Not Published</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="{{ route('admin.articles.show', $article) }}"
                                                       class="btn btn-info btn-sm" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('admin.articles.edit', $article) }}"
                                                       class="btn btn-warning btn-sm" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if(auth()->user()->role === 'admin')
                                                        <form action="{{ route('admin.articles.destroy', $article) }}"
                                                              method="POST" style="display: inline;"
                                                              onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center text-muted">
                                                No articles found. <a href="{{ route('admin.articles.create') }}">Create your first article</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $articles->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
@endpush

@push('scripts')
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#articlesTable').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                order: [[0, 'desc']],
                columnDefs: [
                    { orderable: false, targets: [1, 8] } // Disable sorting for image and actions columns
                ]
            });
        });
    </script>
@endpush
