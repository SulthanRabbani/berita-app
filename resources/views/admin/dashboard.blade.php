@extends('adminlte::page')

@section('title', 'Dashboard Admin')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $stats['users'] }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $stats['published_articles'] }}<sup style="font-size: 20px">/{{ $stats['articles'] }}</sup></h3>
                    <p>Published Articles</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $stats['categories'] }}</h3>
                    <p>Categories</p>
                </div>
                <div class="icon">
                    <i class="ion ion-folder"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $stats['comments'] }}</h3>
                    <p>Comments</p>
                </div>
                <div class="icon">
                    <i class="ion ion-chatbubbles"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Articles</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($stats['recent_articles'] as $article)
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <div class="ms-2 me-auto">
                                    <div class="fw-bold">{{ $article->title }}</div>
                                    <small class="text-muted">
                                        by {{ $article->user->name }} in {{ $article->category->name }}
                                    </small>
                                </div>
                                <span class="badge bg-{{ $article->status === 'published' ? 'success' : 'warning' }} rounded-pill">
                                    {{ ucfirst($article->status) }}
                                </span>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">
                                No articles yet
                            </li>
                        @endforelse
                    </ul>
                </div>
                @if($stats['recent_articles']->count() > 0)
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-sm btn-primary">View All Articles</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Comments</h3>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($stats['recent_comments'] as $comment)
                            <li class="list-group-item">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        @if($comment->user->avatar)
                                            <img src="{{ $comment->user->avatar }}" alt="Avatar" class="rounded-circle" width="32" height="32">
                                        @else
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold">{{ $comment->user->name }}</div>
                                        <div class="text-muted small mb-1">on "{{ Str::limit($comment->article->title, 30) }}"</div>
                                        <div>{{ Str::limit($comment->content, 60) }}</div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">
                                No comments yet
                            </li>
                        @endforelse
                    </ul>
                </div>
                @if($stats['recent_comments']->count() > 0)
                    <div class="card-footer text-center">
                        <a href="#" class="btn btn-sm btn-primary">View All Comments</a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-primary btn-block">
                                <i class="fas fa-plus mr-2"></i>
                                New Article
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-success btn-block">
                                <i class="fas fa-folder mr-2"></i>
                                Manage Categories
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-warning btn-block">
                                <i class="fas fa-tags mr-2"></i>
                                Manage Tags
                            </a>
                        </div>
                        @if(auth()->user()->role === 'admin')
                            <div class="col-md-3 mb-3">
                                <a href="#" class="btn btn-info btn-block">
                                    <i class="fas fa-users mr-2"></i>
                                    Manage Users
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
