@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">User Details</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active">{{ $user->name }}</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <!-- User Profile Card -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ $user->getAvatarUrl(150) }}"
                                 alt="{{ $user->name }}"
                                 style="width: 150px; height: 150px;">
                        </div>

                        <h3 class="profile-username text-center">{{ $user->name }}</h3>

                        <p class="text-muted text-center">
                            @if($user->role === 'admin')
                                <span class="badge badge-danger">Administrator</span>
                            @elseif($user->role === 'editor')
                                <span class="badge badge-warning">Editor</span>
                            @else
                                <span class="badge badge-secondary">Member</span>
                            @endif
                        </p>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>Articles</b> <a class="float-right">{{ $user->articles_count }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Comments</b> <a class="float-right">{{ $user->comments_count }}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Bookmarks</b> <a class="float-right">{{ $user->bookmarks->count() }}</a>
                            </li>
                        </ul>

                        <div class="row">
                            <div class="col-6">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-block">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="{{ route('admin.users.index') }}" class="btn btn-default btn-block">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- User Information -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">User Information</h3>
                    </div>
                    <div class="card-body">
                        <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                        <p class="text-muted">{{ $user->email }}</p>
                        <hr>

                        @if($user->location)
                        <strong><i class="fas fa-map-marker-alt mr-1"></i> Location</strong>
                        <p class="text-muted">{{ $user->location }}</p>
                        <hr>
                        @endif

                        @if($user->website)
                        <strong><i class="fas fa-globe mr-1"></i> Website</strong>
                        <p class="text-muted">
                            <a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a>
                        </p>
                        <hr>
                        @endif

                        <strong><i class="fas fa-calendar-alt mr-1"></i> Member Since</strong>
                        <p class="text-muted">{{ $user->created_at->format('F d, Y') }}</p>

                        @if($user->bio)
                        <hr>
                        <strong><i class="fas fa-user mr-1"></i> Bio</strong>
                        <p class="text-muted">{{ $user->bio }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <!-- Recent Articles -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Articles</h3>
                        <div class="card-tools">
                            <span class="badge badge-primary">{{ $user->articles_count }} total</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($user->articles->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Category</th>
                                            <th>Status</th>
                                            <th>Published</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->articles as $article)
                                        <tr>
                                            <td>
                                                <strong>{{ Str::limit($article->title, 50) }}</strong>
                                                <br>
                                                <small class="text-muted">{{ Str::limit($article->excerpt, 80) }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-info">{{ $article->category->name }}</span>
                                            </td>
                                            <td>
                                                @if($article->status === 'published')
                                                    <span class="badge badge-success">Published</span>
                                                @else
                                                    <span class="badge badge-warning">Draft</span>
                                                @endif
                                            </td>
                                            <td>{{ $article->published_at ? $article->published_at->format('M d, Y') : '-' }}</td>
                                            <td>
                                                <a href="{{ route('admin.articles.show', $article) }}"
                                                   class="btn btn-sm btn-info" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-muted text-center py-4">No articles found.</p>
                        @endif
                    </div>
                </div>

                <!-- Recent Comments -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Comments</h3>
                        <div class="card-tools">
                            <span class="badge badge-secondary">{{ $user->comments_count }} total</span>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($user->comments->count() > 0)
                            <div class="timeline">
                                @foreach($user->comments as $comment)
                                <div class="time-label">
                                    <span class="bg-blue">{{ $comment->created_at->format('M d, Y') }}</span>
                                </div>
                                <div>
                                    <i class="fas fa-comment bg-blue"></i>
                                    <div class="timeline-item">
                                        <span class="time">
                                            <i class="fas fa-clock"></i> {{ $comment->created_at->format('H:i') }}
                                        </span>
                                        <h3 class="timeline-header">
                                            Comment on
                                            <a href="{{ route('admin.articles.show', $comment->article) }}">
                                                {{ $comment->article->title }}
                                            </a>
                                        </h3>
                                        <div class="timeline-body">
                                            {{ Str::limit($comment->content, 200) }}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-muted text-center py-4">No comments found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
