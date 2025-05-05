@extends('layouts.app')

@section('content')
<div class="bg-neutral min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="mb-10">
            <div class="flex justify-between items-center mb-6">
                <h1 class="font-serif text-3xl md:text-4xl text-charcoal font-bold">Your Custom Wallpaper</h1>
                <a href="{{ route('artworks.index') }}" class="text-navy hover:text-navy-light flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to My Artworks
                </a>
            </div>
            
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                        </svg>
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
                        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p>{{ session('error') }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Artwork Details -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-subtle overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">Details</h2>
                        
                        <div class="space-y-6">
                            <div>
                                <h3 class="text-lg font-serif text-charcoal mb-1">{{ $artwork->title }}</h3>
                                <p class="text-sm text-charcoal/70">Submitted on {{ $artwork->created_at->format('M d, Y') }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Description</h4>
                                <p class="text-charcoal">{{ $artwork->description }}</p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Dimensions</h4>
                                <p class="text-charcoal">{{ $artwork->width }} × {{ $artwork->height }} cm</p>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Current Status</h4>
                                <div>
                                    @php
                                        $preview = $artwork->latestPreview;
                                        $previewStatus = $preview ? $preview->status : 'pending';
                                    @endphp
                                    
                                    @if($previewStatus == 'pending')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                            Preview In Progress
                                        </span>
                                    @elseif($previewStatus == 'uploaded')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                            Preview Ready for Approval
                                        </span>
                                    @elseif($previewStatus == 'approved')
                                        <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                            Preview Approved
                                        </span>
                                    @elseif($previewStatus == 'rejected')
                                        <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm">
                                            Preview Rejected
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Selected Paper</h4>
                                @if($artwork->paper)
                                    <div class="flex items-center">
                                        <div class="w-16 h-12 rounded overflow-hidden mr-3">
                                            <img src="{{ asset('storage/' . $artwork->paper->image_path) }}" alt="{{ $artwork->paper->name }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-medium text-charcoal">{{ $artwork->paper->name }}</p>
                                            <p class="text-sm text-charcoal/70">{{ $artwork->paper->size }} • {{ $artwork->paper->thickness_with_unit }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-charcoal/70">No paper selected</p>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Selected Design</h4>
                                @if($artwork->design)
                                    <div class="flex items-center">
                                        <div class="w-16 h-12 rounded overflow-hidden mr-3">
                                            <img src="{{ asset('storage/' . $artwork->design->image_path) }}" alt="{{ $artwork->design->title }}" class="w-full h-full object-cover">
                                        </div>
                                        <div>
                                            <p class="font-medium text-charcoal">{{ $artwork->design->title }}</p>
                                            <p class="text-sm text-charcoal/70">By {{ $artwork->design->designer->name ?? 'Unknown Designer' }}</p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-charcoal/70">No design selected</p>
                                @endif
                            </div>
                            
                            <div>
                                <h4 class="text-sm font-medium text-charcoal/80 mb-2">Your Uploaded Image</h4>
                                @if($artwork->image_path)
                                    <div class="rounded overflow-hidden">
                                        <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="Your uploaded image" class="w-full h-auto">
                                    </div>
                                @else
                                    <p class="text-charcoal/70">No image uploaded</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Preview Section -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-subtle overflow-hidden">
                    <div class="p-6 md:p-8">
                        <h2 class="font-serif text-2xl text-navy mb-6 pb-3 border-b border-neutral">Preview</h2>
                        
                        @php
                            $preview = $artwork->latestPreview;
                            $previewStatus = $preview ? $preview->status : 'pending';
                        @endphp
                        
                        @if($previewStatus == 'pending')
                            <div class="bg-neutral/20 rounded-lg p-8 mb-6 text-center">
                                <div class="w-20 h-20 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-serif text-xl text-charcoal mb-2">Your Preview is Being Created</h3>
                                <p class="text-charcoal/70 max-w-md mx-auto">Our design team is working on creating a beautiful preview of your custom wallpaper. You'll receive a notification when it's ready for your approval.</p>
                            </div>
                            
                            <div class="bg-ivory/50 rounded-lg p-6 border border-gold/20">
                                <h4 class="font-medium text-charcoal mb-3">What happens next?</h4>
                                <ol class="list-decimal list-inside space-y-2 text-charcoal/80">
                                    <li>Our designers will create a custom preview based on your specifications</li>
                                    <li>You'll receive an email notification when your preview is ready</li>
                                    <li>You can review the preview and approve it or request changes</li>
                                    <li>Once approved, you can proceed to place your order</li>
                                </ol>
                            </div>
                        @elseif($preview && $preview->image_path)
                            <div class="mb-6">
                                <div class="aspect-[4/3] bg-neutral/30 rounded-lg mb-4 overflow-hidden">
                                    <img src="{{ asset('storage/' . $preview->image_path) }}" alt="Preview of your wallpaper" class="w-full h-full object-contain">
                                </div>
                                
                                @if($preview->admin_notes)
                                    <div class="bg-neutral/10 rounded-lg p-4 mb-6">
                                        <h4 class="font-medium text-charcoal mb-2">Notes from our design team:</h4>
                                        <p class="text-charcoal/80">{{ $preview->admin_notes }}</p>
                                    </div>
                                @endif
                                
                                @if($preview->status == 'uploaded')
                                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                        <form action="{{ route('artworks.preview.approve', $artwork->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-medium px-8 py-3 rounded-lg transition duration-300 flex items-center justify-center">
                                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Approve Preview
                                            </button>
                                        </form>
                                        
                                        <button type="button" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white font-medium px-8 py-3 rounded-lg transition duration-300 flex items-center justify-center" id="requestChangesBtn">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Request Changes
                                        </button>
                                    </div>
                                    
                                    <!-- Request Changes Form (Hidden initially) -->
                                    <div id="requestChangesForm" class="hidden mt-6 p-6 bg-neutral/10 rounded-lg">
                                        <h4 class="font-medium text-charcoal mb-4">Request Changes to Your Preview</h4>
                                        <form action="{{ route('artworks.preview.reject', $artwork->id) }}" method="POST">
                                            @csrf
                                            <div class="mb-4">
                                                <label for="feedback" class="block text-charcoal/80 mb-2">Please describe the changes you'd like:</label>
                                                <textarea id="feedback" name="feedback" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold/20 transition" required></textarea>
                                            </div>
                                            <div class="flex justify-end">
                                                <button type="button" id="cancelRequestBtn" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition duration-300 mr-3">
                                                    Cancel
                                                </button>
                                                <button type="submit" class="bg-navy hover:bg-navy-light text-white font-medium px-4 py-2 rounded-lg transition duration-300">
                                                    Submit Feedback
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                @elseif($preview->status == 'approved')
                                    <div class="bg-green-100 border-l-4 border-green-500 p-4 mb-6 rounded-lg">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-green-700 font-medium">Preview Approved</p>
                                                <p class="text-green-600 text-sm mt-1">You've approved this preview on {{ $preview->approved_at ? $preview->approved_at->format('M d, Y') : 'N/A' }}.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('artworks.addToCart', $artwork) }}" method="POST" class="mt-4">
                                        @csrf
                                        <button type="submit" class="w-full bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Add to Cart
                                        </button>
                                    </form>
                                @elseif($preview->status == 'rejected')
                                    <div class="bg-red-100 border-l-4 border-red-500 p-4 mb-6 rounded-lg">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-red-700 font-medium">Changes Requested</p>
                                                <p class="text-red-600 text-sm mt-1">You've requested changes to this preview. Our design team will update it soon.</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if($preview->client_feedback)
                                        <div class="bg-neutral/10 rounded-lg p-4 mb-6">
                                            <h4 class="font-medium text-charcoal mb-2">Your Feedback:</h4>
                                            <p class="text-charcoal/80">{{ $preview->client_feedback }}</p>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        @else
                            <div class="bg-neutral/20 rounded-lg p-8 mb-6 text-center">
                                <div class="w-20 h-20 rounded-full bg-navy/10 flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-10 h-10 text-navy" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h3 class="font-serif text-xl text-charcoal mb-2">No Preview Available Yet</h3>
                                <p class="text-charcoal/70 max-w-md mx-auto">Our design team is working on creating a beautiful custom preview for your wallpaper. Please check back soon.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const requestChangesBtn = document.getElementById('requestChangesBtn');
        const cancelRequestBtn = document.getElementById('cancelRequestBtn');
        const requestChangesForm = document.getElementById('requestChangesForm');
        
        if (requestChangesBtn) {
            requestChangesBtn.addEventListener('click', function() {
                requestChangesForm.classList.remove('hidden');
            });
        }
        
        if (cancelRequestBtn) {
            cancelRequestBtn.addEventListener('click', function() {
                requestChangesForm.classList.add('hidden');
            });
        }
    });
</script>
@endpush
@endsection