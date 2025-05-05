@extends('layouts.admin')

@section('title', $design->title)

@section('content')
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.designs.index') }}" class="hover:text-navy">Designs</a>
        <span class="mx-2">/</span>
        <span class="text-navy font-medium">{{ $design->title }}</span>
    </div>
    <div class="flex justify-between items-center mt-2">
        <h1 class="text-3xl font-heading font-bold text-navy">{{ $design->title }}</h1>
        <div>
            <a href="{{ route('admin.designs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg text-sm font-medium text-charcoal transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back to Designs
            </a>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Left Column - Design Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Design Details Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between">
                <h3 class="text-lg font-heading font-semibold text-navy">Design Details</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                    @if($design->status === 'approved') bg-green-100 text-green-800
                    @elseif($design->status === 'pending') bg-amber-100 text-amber-800
                    @elseif($design->status === 'rejected') bg-red-100 text-red-800
                    @else bg-gray-100 text-gray-800
                    @endif">
                    {{ ucfirst($design->status ?? 'Pending') }}
                </span>
            </div>
            <div class="p-6">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 mb-4 md:mb-0">
                        <div class="rounded-lg overflow-hidden bg-gray-50 border border-gray-100">
                            <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-auto object-cover">
                        </div>
                    </div>
                    <div class="md:w-2/3 md:pl-6">
                        <dl class="divide-y divide-gray-100">
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">ID</dt>
                                <dd class="text-sm text-charcoal col-span-2">#{{ $design->id }}</dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Title</dt>
                                <dd class="text-sm text-charcoal col-span-2">{{ $design->title }}</dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Description</dt>
                                <dd class="text-sm text-charcoal col-span-2">{{ $design->description ?? 'No description provided' }}</dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="text-sm text-charcoal col-span-2">
                                    @if($design->category)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $design->category->name }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">Uncategorized</span>
                                    @endif
                                </dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Created</dt>
                                <dd class="text-sm text-charcoal col-span-2">{{ $design->created_at->format('M d, Y g:i A') }}</dd>
                            </div>
                            <div class="py-3 grid grid-cols-3 gap-4">
                                <dt class="text-sm font-medium text-gray-500">Updated</dt>
                                <dd class="text-sm text-charcoal col-span-2">{{ $design->updated_at->format('M d, Y g:i A') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <form action="{{ route('admin.designs.update-status') }}" method="POST" class="flex items-center space-x-4">
                    @csrf
                    <input type="hidden" name="design_id" value="{{ $design->id }}">
                    <div class="text-sm text-gray-500">Change Status:</div>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50 text-sm">
                        <option value="pending" @if($design->status === 'pending') selected @endif>Pending</option>
                        <option value="approved" @if($design->status === 'approved') selected @endif>Approved</option>
                        <option value="rejected" @if($design->status === 'rejected') selected @endif>Rejected</option>
                        <option value="archived" @if($design->status === 'archived') selected @endif>Archived</option>
                    </select>
                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md shadow-sm text-white bg-navy hover:bg-navy/80 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-navy">
                        Update Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Reviews Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between">
                <h3 class="text-lg font-heading font-semibold text-navy">Customer Reviews</h3>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $design->reviews->count() }} Reviews
                </span>
            </div>
            <div class="p-6">
                @if($design->reviews->count() > 0)
                    <div class="space-y-6">
                        @foreach($design->reviews as $review)
                            <div class="bg-gray-50 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 bg-navy/10 rounded-full flex items-center justify-center text-navy">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="ml-3">
                                            <div class="text-sm font-medium text-navy">{{ $review->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $review->created_at->format('M d, Y') }}</div>
                                        </div>
                                    </div>
                                    <div class="flex items-center">
                                        <div class="flex text-amber-500 mr-2">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star"></i>
                                                @else
                                                    <i class="far fa-star"></i>
                                                @endif
                                            @endfor
                                        </div>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($review->is_approved) bg-green-100 text-green-800
                                            @else bg-amber-100 text-amber-800
                                            @endif">
                                            {{ $review->is_approved ? 'Approved' : 'Pending' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-700 mt-2">
                                    {{ $review->comment }}
                                </div>
                                <div class="flex justify-end mt-3 space-x-2">
                                    @if(!$review->is_approved)
                                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="inline-flex items-center text-xs px-2.5 py-1.5 border border-transparent font-medium rounded text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                <i class="fas fa-check mr-1"></i> Approve
                                            </button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-xs px-2.5 py-1.5 border border-transparent font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500" onclick="return confirm('Are you sure you want to delete this review?')">
                                            <i class="fas fa-trash mr-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-comment-slash text-3xl mb-2"></i>
                        <p>No reviews available for this design</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Sidebar - Designer Information and Stats -->
    <div class="space-y-6">
        <!-- Designer Info Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-semibold text-navy">Designer Information</h3>
            </div>
            <div class="p-6">
                <div class="flex items-center mb-4">
                    <div class="h-12 w-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
                        <i class="fas fa-user-circle text-xl"></i>
                    </div>
                    <div class="ml-4">
                        <h4 class="text-md font-medium text-navy">{{ $design->designer->name }}</h4>
                        <p class="text-sm text-gray-500">{{ $design->designer->email }}</p>
                    </div>
                </div>
                
                <dl class="divide-y divide-gray-100">
                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Role</dt>
                        <dd class="text-sm text-charcoal col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                {{ ucfirst($design->designer->role ?? 'Designer') }}
                            </span>
                        </dd>
                    </div>
                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Joined</dt>
                        <dd class="text-sm text-charcoal col-span-2">{{ $design->designer->created_at->format('M d, Y') }}</dd>
                    </div>
                    <div class="py-3 grid grid-cols-3 gap-4">
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-sm text-charcoal col-span-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($design->designer->status === 'active') bg-green-100 text-green-800
                                @elseif($design->designer->status === 'inactive') bg-gray-100 text-gray-800
                                @elseif($design->designer->status === 'suspended') bg-red-100 text-red-800
                                @else bg-amber-100 text-amber-800
                                @endif">
                                {{ ucfirst($design->designer->status ?? 'Active') }}
                            </span>
                        </dd>
                    </div>
                </dl>
                
                <div class="mt-4 border-t border-gray-100 pt-4">
                    <a href="" class="text-sm text-navy hover:underline">View All Designs by {{ $design->designer->name }}</a>
                </div>
            </div>
        </div>
        
        <!-- Design Stats Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-heading font-semibold text-navy">Statistics</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-navy">{{ $design->reviews->count() }}</div>
                        <div class="text-xs text-gray-500 mt-1">Reviews</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-navy">
                            @if($design->reviews->count() > 0)
                                {{ number_format($design->reviews->avg('rating'), 1) }}
                            @else
                                0
                            @endif
                        </div>
                        <div class="text-xs text-gray-500 mt-1">Avg. Rating</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-navy">{{ $design->getArtworkUsageCountAttribute() }}</div>
                        <div class="text-xs text-gray-500 mt-1">Artworks Created</div>
                    </div>
                    <div class="bg-gray-50 p-4 rounded-lg text-center">
                        <div class="text-2xl font-bold text-navy">0</div>
                        <div class="text-xs text-gray-500 mt-1">Total Orders</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
