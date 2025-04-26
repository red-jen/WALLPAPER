@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manage Reviews</h1>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- Pending Reviews -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Pending Reviews</h6>
        </div>
        <div class="card-body">
            @if($pendingReviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Design</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pendingReviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        <a href="{{ route('designs.show', $review->design) }}">
                                            {{ $review->design->title }}
                                        </a>
                                    </td>
                                    <td>{{ $review->rating }}/5</td>
                                    <td>{{ Str::limit($review->comment, 100) }}</td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $pendingReviews->links() }}
            @else
                <p class="text-center mb-0">No pending reviews.</p>
            @endif
        </div>
    </div>

    <!-- Approved Reviews -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Approved Reviews</h6>
        </div>
        <div class="card-body">
            @if($approvedReviews->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Design</th>
                                <th>Rating</th>
                                <th>Comment</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($approvedReviews as $review)
                                <tr>
                                    <td>{{ $review->user->name }}</td>
                                    <td>
                                        <a href="{{ route('designs.show', $review->design) }}">
                                            {{ $review->design->title }}
                                        </a>
                                    </td>
                                    <td>{{ $review->rating }}/5</td>
                                    <td>{{ Str::limit($review->comment, 100) }}</td>
                                    <td>{{ $review->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this review?')">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $approvedReviews->links() }}
            @else
                <p class="text-center mb-0">No approved reviews.</p>
            @endif
        </div>
    </div>
</div>
@endsection