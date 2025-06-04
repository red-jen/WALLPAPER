@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('content')
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <span class="text-navy font-medium">Reviews</span>
    </div>
    <h1 class="text-3xl font-heading font-bold text-navy mt-2">Manage Reviews</h1>
</div>

<!-- Reviews Dashboard -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex gap-4 items-center">
                <h3 class="text-lg font-heading font-semibold text-navy">Review Management</h3>
                <span class="px-3 py-1 rounded-full text-xs font-medium bg-navy/10 text-navy">
                    {{ $totalReviews }} Total
                </span>
            </div>
            
            <div class="relative">
                <input 
                    type="text" 
                    id="reviewSearch" 
                    placeholder="Search reviews..." 
                    class="w-full md:w-64 border border-gray-300 rounded-lg pl-10 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-navy focus:border-transparent text-sm"
                >
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Reviews Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Product
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Reviewer
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Rating
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Comment
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($reviews as $review)
                <tr class="review-row">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="h-10 w-10 flex-shrink-0">
                                @if($review->design_id)
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $review->design->image_path) }}" alt="{{ $review->design->title }}">
                                @elseif($review->wallpaper_id)
                                    <img class="h-10 w-10 rounded-md object-cover" src="{{ $review->wallpaper->getImageUrlAttribute() }}" alt="{{ $review->wallpaper->title }}">
                                @endif
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-gray-900">
                                    @if($review->design_id)
                                        {{ $review->design->title }}
                                        <span class="text-xs text-gray-500">(Design)</span>
                                    @elseif($review->wallpaper_id)
                                        {{ $review->wallpaper->title }}
                                        <span class="text-xs text-gray-500">(Wallpaper)</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $review->user->name }}</div>
                        <div class="text-xs text-gray-500">{{ $review->user->email }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex text-amber-500">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <i class="fas fa-star"></i>
                                @else
                                    <i class="far fa-star"></i>
                                @endif
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 truncate max-w-xs">
                            {{ $review->comment }}
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $review->created_at->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            @if($review->is_approved) bg-green-100 text-green-800
                            @else bg-amber-100 text-amber-800
                            @endif">
                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                        <div class="flex items-center justify-end space-x-2">
                            @if(!$review->is_approved)
                                <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <button 
                                        type="submit" 
                                        class="text-green-600 hover:text-green-900 focus:outline-none"
                                        title="Approve Review"
                                    >
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button 
                                    type="submit" 
                                    class="text-red-600 hover:text-red-900 focus:outline-none"
                                    title="Delete Review"
                                    onclick="return confirm('Are you sure you want to delete this review?')"
                                >
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                        No reviews found
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <!-- Pagination -->
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $reviews->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Search functionality
        const searchInput = document.getElementById('reviewSearch');
        const reviewRows = document.querySelectorAll('.review-row');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            
            reviewRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                
                if (text.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush