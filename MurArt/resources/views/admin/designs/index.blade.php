@extends('layouts.admin')

@section('title', 'Manage Designs')

@section('content')
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-navy font-medium">Designs</span>
    </div>
    <h1 class="text-3xl font-heading font-bold text-navy mt-2">Manage Designs</h1>
</div>

<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-heading font-semibold text-navy">All Designs</h3>
        
        <div class="flex items-center space-x-3">
            <div class="relative">
                <input type="text" id="designSearch" class="block w-64 border border-gray-300 rounded-md px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Search designs...">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
            
            <select id="statusFilter" class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="approved">Approved</option>
                <option value="rejected">Rejected</option>
                <option value="archived">Archived</option>
            </select>
        </div>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Design</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Designer</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($designs as $design)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-md overflow-hidden flex-shrink-0">
                                    <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="h-full w-full object-cover">
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium text-navy">{{ $design->title }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-700">{{ $design->designer->name }}</div>
                            <div class="text-xs text-gray-500">{{ $design->designer->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $design->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex flex-wrap gap-1">
                                @if($design->category)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $design->category->name }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Uncategorized
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <form action="{{ route('admin.designs.update-status') }}" method="POST" class="inline">
                                @csrf
                                <input type="hidden" name="design_id" value="{{ $design->id }}">
                                <select name="status" onchange="this.form.submit()" class="text-xs rounded-full border px-2 py-1 cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy font-medium
                                    @if($design->status === 'approved') bg-green-100 text-green-800 border-green-200
                                    @elseif($design->status === 'pending') bg-yellow-100 text-yellow-800 border-yellow-200
                                    @elseif($design->status === 'rejected') bg-red-100 text-red-800 border-red-200
                                    @else bg-gray-100 text-gray-800 border-gray-200
                                    @endif">
                                    <option value="approved" @if($design->status === 'approved') selected @endif>Approved</option>
                                    <option value="pending" @if($design->status === 'pending') selected @endif>Pending</option>
                                    <option value="rejected" @if($design->status === 'rejected') selected @endif>Rejected</option>
                                    <option value="archived" @if($design->status === 'archived') selected @endif>Archived</option>
                                </select>
                            </form>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.designs.show', $design) }}" class="text-navy hover:underline mr-3">
                                <i class="fas fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">No designs found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-200">
        {{ $designs->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('designSearch');
        const statusFilter = document.getElementById('statusFilter');
        
        // Function to handle filtering
        function filterDesigns() {
            const searchQuery = searchInput.value;
            const status = statusFilter.value;
            
            window.location.href = `{{ route('admin.designs.index') }}?search=${encodeURIComponent(searchQuery)}&status=${encodeURIComponent(status)}`;
        }
        
        // Add debounced event listeners
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(filterDesigns, 500);
        });
        
        statusFilter.addEventListener('change', filterDesigns);
    });
</script>
@endpush
