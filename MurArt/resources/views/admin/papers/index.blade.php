@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Paper Types</h1>
        <a href="{{ route('admin.papers.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Add New Paper Type
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Paper Types List</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Thickness</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($papers as $paper)
                            <tr>
                                <td>{{ $paper->id }}</td>
                                <td>
                                    @if($paper->image_path)
                                        <img src="{{ asset('storage/' . $paper->image_path) }}" 
                                             alt="{{ $paper->name }}" 
                                             class="img-thumbnail" 
                                             style="max-height: 50px;">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $paper->name }}</td>
                                <td>{{ $paper->type }}</td>
                                <td>{{ $paper->thickness ? $paper->thickness . ' GSM' : 'N/A' }}</td>
                                <td>{{ $paper->size ?? 'N/A' }}</td>
                                <td>{{ $paper->price ? $paper->formatted_price : 'N/A' }}</td>
                                <td>
                                    <span class="badge badge-{{ $paper->is_active ? 'success' : 'danger' }}">
                                        {{ $paper->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.papers.show', $paper) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.papers.edit', $paper) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.papers.destroy', $paper) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this paper type?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $papers->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            "paging": false,
            "searching": true,
            "ordering": true,
            "info": false,
        });
    });
</script>
@endpush