@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tag Details</h1>
        <div>
            <a href="{{ route('admin.tags.index') }}" class="btn btn-sm btn-secondary shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Tags
            </a>
            <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-edit fa-sm text-white-50"></i> Edit Tag
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $tag->name }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <strong>ID:</strong> {{ $tag->id }}
                    </div>
                    
                    <div class="mb-4">
                        <strong>Name:</strong> {{ $tag->name }}
                    </div>
                    
                    <div class="mb-4">
                        <strong>Total Designs:</strong> {{ $tag->designs_count ?? $tag->designs->count() }}
                    </div>
                    
                    <div class="mb-4">
                        <strong>Created:</strong> {{ $tag->created_at->format('F d, Y h:i A') }}
                    </div>
                    
                    <div class="mb-4">
                        <strong>Last Updated:</strong> {{ $tag->updated_at->format('F d, Y h:i A') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Designs with this Tag -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Designs with this Tag</h6>
        </div>
        <div class="card-body">
            @if($tag->designs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Designer</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tag->designs as $design)
                                <tr>
                                    <td>{{ $design->id }}</td>
                                    <td>{{ $design->title }}</td>
                                    <td>{{ $design->user->name }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                            $design->status === 'published' ? 'success' : 
                                            ($design->status === 'pending' ? 'warning' : 
                                            ($design->status === 'rejected' ? 'danger' : 'secondary')) 
                                        }}">
                                            {{ ucfirst($design->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $design->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.designs.show', $design) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No designs are associated with this tag yet.</p>
            @endif
        </div>
    </div>
</div>
@endsection