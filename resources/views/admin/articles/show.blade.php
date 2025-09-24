@extends('layouts.admin')

@section('title', 'View Article')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>View Article</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">Articles</a></li>
                    <li class="breadcrumb-item active">View</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $article->title }}</h3>
                        <div class="card-tools">
                            <div class="btn-group">
                                <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if(auth()->user()->role === 'admin')
                                    <form action="{{ route('admin.articles.destroy', $article) }}"
                                          method="POST" style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this article?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($article->featured_image)
                            <div class="text-center mb-4">
                                <img src="{{ Storage::url($article->featured_image) }}"
                                     alt="Featured Image"
                                     class="img-fluid rounded"
                                     style="max-height: 400px;">
                            </div>
                        @endif

                        @if($article->excerpt)
                            <div class="alert alert-info">
                                <h5><i class="icon fas fa-info"></i> Excerpt</h5>
                                {{ $article->excerpt }}
                            </div>
                        @endif

                        <div class="article-content">
                            {!! $article->content !!}
                        </div>

                        @if($article->tags->count() > 0)
                            <hr>
                            <div class="tags">
                                <h5>Tags:</h5>
                                @foreach($article->tags as $tag)
                                    <span class="badge badge-secondary mr-1">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Comments Section -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Comments ({{ $article->comments->count() }})</h3>
                    </div>
                    <div class="card-body">
                        @forelse($article->comments->where('parent_id', null)->take(5) as $comment)
                            <div class="comment mb-3">
                                <div class="d-flex">
                                    <img src="{{ $comment->user->getAvatarUrl(50) }}"
                                         alt="Avatar"
                                         class="img-circle mr-3"
                                         style="width: 50px; height: 50px;">
                                    <div class="flex-grow-1">
                                        <div class="comment-header">
                                            <strong>{{ $comment->user->name }}</strong>
                                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                                        </div>
                                        <div class="comment-content">
                                            {{ $comment->content }}
                                        </div>
                                        @if($comment->replies->count() > 0)
                                            <div class="replies ml-4 mt-2">
                                                @foreach($comment->replies->take(3) as $reply)
                                                    <div class="reply d-flex mb-2">
                                                        <img src="{{ $reply->user->getAvatarUrl(40) }}"
                                                             alt="Avatar"
                                                             class="img-circle mr-2"
                                                             style="width: 40px; height: 40px;">
                                                        <div>
                                                            <div class="reply-header">
                                                                <strong>{{ $reply->user->name }}</strong>
                                                                <small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                            </div>
                                                            <div class="reply-content">
                                                                {{ $reply->content }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @if($comment->replies->count() > 3)
                                                    <small class="text-muted">
                                                        and {{ $comment->replies->count() - 3 }} more replies...
                                                    </small>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr>
                            @endif
                        @empty
                            <p class="text-muted text-center">No comments yet.</p>
                        @endforelse

                        @if($article->comments->where('parent_id', null)->count() > 5)
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    Showing 5 of {{ $article->comments->where('parent_id', null)->count() }} comments
                                </small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Article Info -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Article Information</h3>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <dt class="col-sm-4">Status:</dt>
                            <dd class="col-sm-8">
                                @if($article->status === 'published')
                                    <span class="badge badge-success">Published</span>
                                @elseif($article->status === 'draft')
                                    <span class="badge badge-secondary">Draft</span>
                                @else
                                    <span class="badge badge-warning">Archived</span>
                                @endif
                            </dd>

                            <dt class="col-sm-4">Author:</dt>
                            <dd class="col-sm-8">{{ $article->user->name }}</dd>

                            <dt class="col-sm-4">Category:</dt>
                            <dd class="col-sm-8">
                                <span class="badge badge-info">{{ $article->category->name }}</span>
                            </dd>

                            <dt class="col-sm-4">Views:</dt>
                            <dd class="col-sm-8">{{ number_format($article->views_count) }}</dd>

                            <dt class="col-sm-4">Slug:</dt>
                            <dd class="col-sm-8">
                                <code>{{ $article->slug }}</code>
                            </dd>

                            <dt class="col-sm-4">Created:</dt>
                            <dd class="col-sm-8">{{ $article->created_at->format('M d, Y H:i') }}</dd>

                            <dt class="col-sm-4">Updated:</dt>
                            <dd class="col-sm-8">{{ $article->updated_at->format('M d, Y H:i') }}</dd>

                            @if($article->published_at)
                                <dt class="col-sm-4">Published:</dt>
                                <dd class="col-sm-8">{{ $article->published_at->format('M d, Y H:i') }}</dd>
                            @endif
                        </dl>
                    </div>
                </div>

                <!-- Article Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Statistics</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-info">
                                    <span class="info-box-icon"><i class="fas fa-eye"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Views</span>
                                        <span class="info-box-number">{{ number_format($article->views_count) }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-success">
                                    <span class="info-box-icon"><i class="fas fa-comments"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Comments</span>
                                        <span class="info-box-number">{{ $article->comments->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="info-box bg-warning">
                                    <span class="info-box-icon"><i class="fas fa-bookmark"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Bookmarks</span>
                                        <span class="info-box-number">{{ $article->bookmarks->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-box bg-secondary">
                                    <span class="info-box-icon"><i class="fas fa-tags"></i></span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">Tags</span>
                                        <span class="info-box-number">{{ $article->tags->count() }}</span>
                                    </div>
                                </div>
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
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary btn-block">
                                <i class="fas fa-arrow-left"></i> Back to Articles
                            </a>
                            <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-warning btn-block">
                                <i class="fas fa-edit"></i> Edit Article
                            </a>
                            @if($article->status === 'published')
                                <a href="#" class="btn btn-info btn-block" target="_blank">
                                    <i class="fas fa-external-link-alt"></i> View on Site
                                </a>
                            @endif
                            <a href="{{ route('admin.articles.create') }}" class="btn btn-success btn-block">
                                <i class="fas fa-plus"></i> Create New Article
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
    <style>
        .article-content {
            line-height: 1.8;
            font-size: 16px;
        }
        .article-content img {
            max-width: 100%;
            height: auto;
            margin: 15px 0;
        }
        .article-content h1, .article-content h2, .article-content h3 {
            margin-top: 25px;
            margin-bottom: 15px;
        }
        .article-content p {
            margin-bottom: 15px;
        }
        .comment {
            border-left: 3px solid #007bff;
            padding-left: 15px;
        }
        .reply {
            border-left: 2px solid #6c757d;
            padding-left: 10px;
        }
    </style>
@endpush
