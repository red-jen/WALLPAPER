@extends('layouts.admin')

@section('title', 'Paper Types Management')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Papers</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Paper Types</h1>
    <a href="{{ route('admin.papers.create') }}" class="inline-flex items-center px-4 py-2 bg-gold hover:bg-gold-light text-white rounded-lg transition-colors duration-150">
        <i class="fas fa-plus mr-2"></i> Add New Paper Type
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-check-circle h-5 w-5 text-green-500"></i>
            </div>
            <div class="ml-3">
                <p>{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
            </div>
            <div class="ml-3">
                <p>{{ session('error') }}</p>
            </div>
        </div>
    </div>
@endif

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm mb-6 p-4">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label for="searchFilter" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
                <input type="text" id="searchFilter" class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Search papers...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/4">
            <label for="typeFilter" class="block text-sm font-medium text-gray-700 mb-1">Paper Type</label>
            <select id="typeFilter" class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Types</option>
                @foreach($paperTypes ?? [] as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                @endforeach
            </select>
        </div>
        <div class="w-full md:w-1/4">
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="statusFilter" class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>
    </div>
</div>

<!-- Papers List -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="font-heading font-semibold text-lg text-navy">Paper Types List</h2>
        <span class="text-sm text-gray-600">{{ $papers->total() }} items</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thickness</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="papersTableBody">
                @forelse($papers as $paper)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="h-12 w-12 rounded overflow-hidden bg-gray-100 flex items-center justify-center">
                                @if($paper->image_path)
                                    <img src="{{ asset('storage/' . $paper->image_path) }}" alt="{{ $paper->name }}" class="h-full w-full object-cover">
                                @else
                                    <i class="fas fa-scroll text-gray-400 text-xl"></i>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm font-medium text-gray-900">{{ $paper->name }}</div>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $paper->type }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $paper->thickness ? $paper->thickness . ' GSM' : 'N/A' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $paper->size ?? 'N/A' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            {{ $paper->price ? $paper->formatted_price : 'N/A' }}
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $paper->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $paper->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.papers.show', $paper) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.papers.edit', $paper) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    type="button" 
                                    class="text-red-600 hover:text-red-900 transition-colors" 
                                    title="Delete"
                                    onclick="openDeleteModal('{{ $paper->id }}', '{{ $paper->name }}')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-scroll text-4xl mb-3 text-gray-300"></i>
                                <p class="text-base">No paper types found</p>
                                <a href="{{ route('admin.papers.create') }}" class="mt-3 text-sm text-indigo-600 hover:text-indigo-900">Add your first paper type</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($papers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $papers->links() }}
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="text-center mb-6">
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <i class="fas fa-exclamation-triangle text-red-600"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">Delete Paper Type</h3>
            <p class="text-sm text-gray-500" id="deleteModalText">Are you sure you want to delete this paper type?</p>
        </div>
        <form id="deleteForm" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-center space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                    Delete
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Delete modal functionality
    function openDeleteModal(paperId, paperName) {
        document.getElementById('deleteForm').action = '/admin/papers/' + paperId;
        document.getElementById('deleteModalText').textContent = 'Are you sure you want to delete "' + paperName + '"? This action cannot be undone.';
        document.getElementById('deleteModal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
    
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchFilter');
        const typeSelect = document.getElementById('typeFilter');
        const statusSelect = document.getElementById('statusFilter');
        
        // Add listeners to filter elements
        [searchInput, typeSelect, statusSelect].forEach(element => {
            if (element) {
                element.addEventListener('change', filterPapers);
                if (element === searchInput) {
                    element.addEventListener('keyup', debounce(filterPapers, 300));
                }
            }
        });
        
        function filterPapers() {
            // Implementation would go here - either client-side filtering or AJAX request
            console.log('Filtering with:', {
                search: searchInput?.value || '',
                type: typeSelect?.value || '',
                status: statusSelect?.value || ''
            });
            
            // Example: You could implement AJAX filtering here
        }
        
        // Debounce function to avoid multiple rapid requests
        function debounce(func, delay) {
            let timeout;
            return function() {
                const context = this;
                const args = arguments;
                clearTimeout(timeout);
                timeout = setTimeout(() => func.apply(context, args), delay);
            };
        }
        
        // Close modal on outside click
        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('deleteModal').classList.contains('hidden')) {
                closeDeleteModal();
            }
        });
    });
</script>
@endpush
@endsection