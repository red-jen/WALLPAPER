@extends('layouts.admin')

@section('title', 'Wallpapers Management')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Wallpapers</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Wallpapers Management</h1>
    <a href="{{ route('admin.wallpapers.create') }}" class="inline-flex items-center px-4 py-2 bg-gold hover:bg-gold-light text-white rounded-lg transition-colors duration-150">
        <i class="fas fa-plus mr-2"></i> Add New Wallpaper
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

<!-- Filters -->
<div class="bg-white rounded-xl shadow-sm mb-6 p-4">
    <div class="flex flex-col md:flex-row gap-4">
        <div class="flex-1">
            <label for="searchFilter" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
            <div class="relative">
                <input type="text" id="searchFilter" class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent" placeholder="Search wallpapers...">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
        <div class="w-full md:w-1/4">
            <label for="categoryFilter" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
            <select id="categoryFilter" class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Categories</option>
                @if(isset($categories))
                    @foreach($categories as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="w-full md:w-1/4">
            <label for="statusFilter" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
            <select id="statusFilter" class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent">
                <option value="">All Statuses</option>
                <option value="draft">Draft</option>
                <option value="published">Published</option>
                <option value="featured">Featured</option>
            </select>
        </div>
    </div>
</div>

<!-- Wallpapers Grid -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
        <h2 class="font-heading font-semibold text-lg text-navy">All Wallpapers</h2>
        <span class="text-sm text-gray-600">{{ $wallpapers->total() }} wallpapers</span>
    </div>
    
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200" id="wallpapersTableBody">
                @forelse($wallpapers as $wallpaper)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="h-16 w-16 rounded overflow-hidden bg-gray-100">
                                <img src="{{ $wallpaper->imageUrl }}" alt="{{ $wallpaper->title }}" class="h-full w-full object-cover">
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm font-medium text-gray-900 max-w-xs truncate">{{ $wallpaper->title }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $wallpaper->category->name ?? 'No Category' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                            ${{ number_format($wallpaper->price, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium {{ $wallpaper->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $wallpaper->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($wallpaper->status == 'draft')
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">Draft</span>
                            @elseif($wallpaper->status == 'published')
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Published</span>
                            @elseif($wallpaper->status == 'featured')
                                <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">Featured</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.wallpapers.show', $wallpaper) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.wallpapers.edit', $wallpaper) }}" class="text-blue-600 hover:text-blue-900 transition-colors" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    type="button" 
                                    class="text-red-600 hover:text-red-900 transition-colors" 
                                    title="Delete"
                                    onclick="if(confirm('Are you sure you want to delete this wallpaper?')) document.getElementById('delete-form-{{ $wallpaper->id }}').submit();"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $wallpaper->id }}" action="{{ route('admin.wallpapers.destroy', $wallpaper) }}" method="POST" class="hidden">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <button 
                                    type="button" 
                                    class="text-yellow-600 hover:text-yellow-900 transition-colors"
                                    title="Update Stock"
                                    onclick="openStockModal('{{ $wallpaper->id }}', {{ $wallpaper->stock }})"
                                >
                                    <i class="fas fa-boxes"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <i class="fas fa-images text-4xl mb-3 text-gray-300"></i>
                                <p class="text-base">No wallpapers found</p>
                                <a href="{{ route('admin.wallpapers.create') }}" class="mt-3 text-sm text-indigo-600 hover:text-indigo-900">Add your first wallpaper</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    @if($wallpapers->hasPages())
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $wallpapers->links() }}
        </div>
    @endif
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Update Stock</h3>
            <button type="button" onclick="closeStockModal()" class="text-gray-400 hover:text-gray-500">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <form id="stockUpdateForm" action="" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity</label>
                <input type="number" id="stockInput" name="stock" min="0" class="w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent p-2">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeStockModal()" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Stock modal functionality
    function openStockModal(wallpaperId, currentStock) {
        document.getElementById('stockUpdateForm').action = '/admin/wallpapers/' + wallpaperId + '/stock';
        document.getElementById('stockInput').value = currentStock;
        document.getElementById('stockModal').classList.remove('hidden');
    }
    
    function closeStockModal() {
        document.getElementById('stockModal').classList.add('hidden');
    }
    
    // Filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchFilter');
        const categorySelect = document.getElementById('categoryFilter');
        const statusSelect = document.getElementById('statusFilter');
        
        // Add listeners to filter elements
        [searchInput, categorySelect, statusSelect].forEach(element => {
            if (element) {
                element.addEventListener('change', filterWallpapers);
                if (element === searchInput) {
                    element.addEventListener('keyup', debounce(filterWallpapers, 300));
                }
            }
        });
        
        function filterWallpapers() {
            // Implementation would go here - either client-side filtering or AJAX request
            console.log('Filtering with:', {
                search: searchInput?.value || '',
                category: categorySelect?.value || '',
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
        document.getElementById('stockModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeStockModal();
            }
        });
        
        // Close modal on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('stockModal').classList.contains('hidden')) {
                closeStockModal();
            }
        });
    });
</script>
@endpush
@endsection