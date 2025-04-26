@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Wallpapers</h1>
        <a href="{{ route('admin.wallpapers.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Wallpaper
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">All Wallpapers</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="wallpapersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wallpapers as $wallpaper)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ $wallpaper->imageUrl }}" alt="{{ $wallpaper->title }}" class="img-thumbnail" style="max-width: 80px; max-height: 80px;">
                                </td>
                                <td>{{ $wallpaper->title }}</td>
                                <td>{{ $wallpaper->category->name ?? 'No Category' }}</td>
                                <td>${{ number_format($wallpaper->price, 2) }}</td>
                                <td>
                                    <span class="badge {{ $wallpaper->stock > 0 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $wallpaper->stock }}
                                    </span>
                                </td>
                                <td>
                                    @if($wallpaper->status == 'draft')
                                        <span class="badge badge-secondary">Draft</span>
                                    @elseif($wallpaper->status == 'published')
                                        <span class="badge badge-success">Published</span>
                                    @elseif($wallpaper->status == 'featured')
                                        <span class="badge badge-primary">Featured</span>
                                    @endif
                                </td>
                                <td>{{ $wallpaper->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.wallpapers.show', $wallpaper) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.wallpapers.edit', $wallpaper) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal{{ $wallpaper->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <!-- Quick Stock Update -->
                                    <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#stockModal{{ $wallpaper->id }}">
                                        <i class="fas fa-boxes"></i>
                                    </button>
                                    
                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal{{ $wallpaper->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel{{ $wallpaper->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $wallpaper->id }}">Delete Wallpaper</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete <strong>{{ $wallpaper->title }}</strong>? This action cannot be undone.
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                    <form action="{{ route('admin.wallpapers.destroy', $wallpaper) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Stock Update Modal -->
                                    <div class="modal fade" id="stockModal{{ $wallpaper->id }}" tabindex="-1" role="dialog" aria-labelledby="stockModalLabel{{ $wallpaper->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="stockModalLabel{{ $wallpaper->id }}">Update Stock</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('admin.wallpapers.updateStock', $wallpaper) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label for="stock{{ $wallpaper->id }}">Stock Quantity</label>
                                                            <input type="number" class="form-control" id="stock{{ $wallpaper->id }}" name="stock" value="{{ $wallpaper->stock }}" min="0">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No wallpapers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-3">
                {{ $wallpapers->links() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#wallpapersTable').DataTable({
            "paging": false,
            "ordering": true,
            "info": false,
            "searching": true
        });
    });
</script>
@endpush
@endsection