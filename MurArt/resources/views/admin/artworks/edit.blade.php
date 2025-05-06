@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage Artwork Preview</h1>
        <div>
            <a href="{{ route('admin.artworks.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Artworks
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm animate__animated animate__fadeIn">
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Artwork Details -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-100">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="font-medium text-lg text-gray-800">Artwork Request Details</h2>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $artwork->title }}</h3>
                        <p class="text-sm text-gray-600">ID: <span class="font-mono bg-gray-100 px-1 py-0.5 rounded">{{ $artwork->id }}</span></p>
                        <p class="text-sm text-gray-600">Submitted: {{ $artwork->created_at->format('M d, Y') }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Description</h4>
                        <p class="text-gray-800">{{ $artwork->description }}</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Dimensions</h4>
                        <p class="text-gray-800">{{ $artwork->width }} × {{ $artwork->height }} cm</p>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Paper</h4>
                        <div class="flex items-center">
                            @if($artwork->paper)
                                <div class="w-12 h-12 rounded-md overflow-hidden mr-3">
                                    <img src="{{ asset('storage/' . $artwork->paper->image_path) }}" alt="{{ $artwork->paper->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $artwork->paper->name }}</p>
                                    <p class="text-xs text-gray-600">{{ $artwork->paper->size }} • {{ $artwork->paper->thickness_with_unit }}</p>
                                </div>
                            @else
                                <p class="text-gray-500">No paper selected</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-6">
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Design</h4>
                        <div class="flex items-center">
                            @if($artwork->design)
                                <div class="w-12 h-12 rounded-md overflow-hidden mr-3">
                                    <img src="{{ asset('storage/' . $artwork->design->image_path) }}" alt="{{ $artwork->design->title }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">{{ $artwork->design->title }}</p>
                                    <p class="text-xs text-gray-600">By {{ $artwork->design->designer->name ?? 'Unknown Designer' }}</p>
                                </div>
                            @elseif($artwork->custom_design_path)
                                <div class="w-12 h-12 rounded-md overflow-hidden mr-3">
                                    <img src="{{ asset('storage/' . $artwork->custom_design_path) }}" alt="Custom design" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="font-medium text-gray-800">Custom uploaded design</p>
                                </div>
                            @else
                                <p class="text-gray-500">No design selected</p>
                            @endif
                        </div>
                    </div>

                    <div>
                        <h4 class="text-sm font-medium text-gray-700 mb-2">Reference Image</h4>
                        @if($artwork->image_path)
                            <div class="rounded-md overflow-hidden border border-gray-200">
                                <img src="{{ asset('storage/' . $artwork->image_path) }}" alt="Reference image" class="w-full h-auto">
                            </div>
                        @else
                            <p class="text-gray-500">No reference image uploaded</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Preview Management -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8 border border-gray-100">
                <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h2 class="font-medium text-lg text-gray-800">Preview Management</h2>
                </div>
                <div class="p-6">
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <h3 class="text-lg font-semibold text-gray-800 mr-3">Current Status:</h3> 
                            @if($artwork->preview_status == 'pending')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Pending Preview
                                </span>
                            @elseif($artwork->preview_status == 'uploaded')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Awaiting Customer Approval
                                </span>
                            @elseif($artwork->preview_status == 'approved')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Approved
                                </span>
                            @elseif($artwork->preview_status == 'rejected')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="3" />
                                    </svg>
                                    Rejected
                                </span>
                            @endif
                        </div>

                        <!-- Client Feedback Section for Rejected Previews -->
                        @if($artwork->latestPreview && $artwork->latestPreview->status == 'rejected' && $artwork->latestPreview->client_feedback)
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-5 rounded-md">
                            <div class="flex items-center mb-3">
                                <svg class="h-6 w-6 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                                <h4 class="text-base font-medium text-red-800">Client Feedback on Rejected Preview</h4>
                            </div>
                            <div class="ml-8 p-4 bg-white rounded-md shadow-sm border border-red-100">
                                <p class="text-red-700 whitespace-pre-line">{{ $artwork->latestPreview->client_feedback }}</p>
                                <div class="flex items-center mt-3 pt-2 border-t border-red-100">
                                    <svg class="w-4 h-4 text-red-400 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-sm text-red-600">Rejected on: {{ $artwork->latestPreview->rejected_at ? $artwork->latestPreview->rejected_at->format('M d, Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Current Preview Image -->
                        @if($artwork->latestPreview && $artwork->latestPreview->image_path)
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Current Preview Image</h4>
                                <div class="rounded-md overflow-hidden border border-gray-200 mb-3">
                                    <img src="{{ asset('storage/' . $artwork->latestPreview->image_path) }}" alt="Preview image" class="w-full h-auto">
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm text-gray-500">Uploaded: {{ $artwork->latestPreview->created_at ? $artwork->latestPreview->created_at->format('M d, Y H:i') : 'N/A' }}</span>
                                    <form action="{{ route('admin.artworks.preview.delete', $artwork->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this preview image?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-100 text-red-700 rounded-md text-sm hover:bg-red-200">
                                            Delete Preview
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <!-- Upload New Preview -->
                        <div class="mb-6">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">{{ $artwork->preview_image_path ? 'Upload New Preview' : 'Upload Preview Image' }}</h4>
                            <form action="{{ route('admin.artworks.preview.store', $artwork->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition cursor-pointer" id="dropzone">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="preview_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                    <span>Upload a file</span>
                                                    <input id="preview_image" name="preview_image" type="file" class="sr-only" accept="image/*" required>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">
                                                PNG, JPG, GIF up to 4MB
                                            </p>
                                        </div>
                                    </div>
                                    <div id="preview-container" class="mt-3 hidden">
                                        <img id="preview-image" src="#" alt="Preview" class="h-48 object-contain mx-auto rounded border border-gray-300">
                                        <button type="button" id="remove-image" class="mt-2 text-sm text-red-500 hover:text-red-700">Remove image</button>
                                    </div>
                                    @error('preview_image')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="mb-4">
                                    <label for="preview_notes" class="block text-sm font-medium text-gray-700 mb-1">Notes for Customer</label>
                                    <textarea id="preview_notes" name="preview_notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add any notes about the preview for the customer...">{{ old('preview_notes') }}</textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                        Upload & Notify Customer
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Update Status -->
                        <div>
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Update Status</h4>
                            <form action="{{ route('admin.artworks.status.update', $artwork->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <div class="mb-4">
                                    <label for="preview_status" class="block text-sm font-medium text-gray-700 mb-1">Preview Status</label>
                                    <select id="preview_status" name="preview_status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                        <option value="pending" {{ $artwork->preview_status == 'pending' ? 'selected' : '' }}>Pending Preview</option>
                                        <option value="uploaded" {{ $artwork->preview_status == 'uploaded' ? 'selected' : '' }}>Awaiting Customer Approval</option>
                                        <option value="approved" {{ $artwork->preview_status == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $artwork->preview_status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="status_notes" class="block text-sm font-medium text-gray-700 mb-1">Status Notes</label>
                                    <textarea id="status_notes" name="status_notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add notes about this status change...">{{ old('status_notes', $artwork->status_notes) }}</textarea>
                                </div>
                                
                                <div class="flex justify-end">
                                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">
                                        Update Status
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Final Product Images Section (only visible if artwork is approved) -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="font-medium">Production & Shipping Images</h2>
                </div>
                <div class="p-6">
                    @if($artwork->preview_status == 'approved')
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Final Product Images</h3>
                            
                            <!-- Current Production Images -->
                            @if(isset($artwork->production_images) && count($artwork->production_images) > 0)
                                <div class="mb-6">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Current Production Images</h4>
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 mb-4">
                                        @foreach($artwork->production_images as $index => $image)
                                            <div class="relative group">
                                                <div class="rounded-md overflow-hidden border border-gray-200 aspect-square">
                                                    <img src="{{ asset('storage/' . $image) }}" alt="Production image {{ $index + 1 }}" class="w-full h-full object-cover">
                                                </div>
                                                <form action="{{ route('admin.artworks.production-image.delete', ['artwork' => $artwork->id, 'index' => $index]) }}" method="POST" class="absolute top-1 right-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white rounded-full p-1 hover:bg-red-600" onclick="return confirm('Delete this image?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="text-center bg-gray-50 rounded-lg p-6 mb-6">
                                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="text-gray-600">No production images have been uploaded yet.</p>
                                </div>
                            @endif

                            <!-- Add Production Images Form -->
                            <div class="mb-6">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Add Production Image</h4>
                                <form action="{{ route('admin.artworks.production-image.store', $artwork->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-4">
                                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:bg-gray-50 transition cursor-pointer" id="production-dropzone">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-gray-600">
                                                    <label for="production_image" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                        <span>Upload a file</span>
                                                        <input id="production_image" name="production_image" type="file" class="sr-only" accept="image/*" required>
                                                    </label>
                                                    <p class="pl-1">or drag and drop</p>
                                                </div>
                                                <p class="text-xs text-gray-500">
                                                    PNG, JPG, GIF up to 5MB
                                                </p>
                                            </div>
                                        </div>
                                        <div id="production-preview-container" class="mt-3 hidden">
                                            <img id="production-preview-image" src="#" alt="Preview" class="h-48 object-contain mx-auto rounded border border-gray-300">
                                            <button type="button" id="remove-production-image" class="mt-2 text-sm text-red-500 hover:text-red-700">Remove image</button>
                                        </div>
                                        @error('production_image')
                                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="image_type" class="block text-sm font-medium text-gray-700 mb-1">Image Type</label>
                                        <select id="image_type" name="image_type" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="production">Production Process</option>
                                            <option value="ready">Ready for Shipping</option>
                                            <option value="packaging">Packaging</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="image_note" class="block text-sm font-medium text-gray-700 mb-1">Image Note (Optional)</label>
                                        <textarea id="image_note" name="image_note" rows="2" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add a note about this image..."></textarea>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input id="notify_customer" name="notify_customer" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="notify_customer" class="ml-2 block text-sm text-gray-700">
                                                Notify customer about this update
                                            </label>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                            Upload Image
                                        </button>
                                    </div>
                                </form>
                            </div>

                            <!-- Update Production Status -->
                            <div>
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Update Production Status</h4>
                                <form action="{{ route('admin.artworks.production-status.update', $artwork->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-4">
                                        <label for="production_status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                        <select id="production_status" name="production_status" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="queued" {{ isset($artwork->production_status) && $artwork->production_status == 'queued' ? 'selected' : '' }}>In Production Queue</option>
                                            <option value="in_progress" {{ isset($artwork->production_status) && $artwork->production_status == 'in_progress' ? 'selected' : '' }}>Production In Progress</option>
                                            <option value="ready" {{ isset($artwork->production_status) && $artwork->production_status == 'ready' ? 'selected' : '' }}>Ready for Shipping</option>
                                            <option value="shipped" {{ isset($artwork->production_status) && $artwork->production_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                            <option value="delivered" {{ isset($artwork->production_status) && $artwork->production_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="tracking_number" class="block text-sm font-medium text-gray-700 mb-1">Tracking Number (if shipped)</label>
                                        <input type="text" id="tracking_number" name="tracking_number" value="{{ $artwork->tracking_number ?? '' }}" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    
                                    <div class="mb-4">
                                        <label for="production_notes" class="block text-sm font-medium text-gray-700 mb-1">Production Notes</label>
                                        <textarea id="production_notes" name="production_notes" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="Add notes about production or shipping...">{{ $artwork->production_notes ?? '' }}</textarea>
                                    </div>
                                    
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <input id="notify_production_update" name="notify_production_update" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <label for="notify_production_update" class="ml-2 block text-sm text-gray-700">
                                                Notify customer about this update
                                            </label>
                                        </div>
                                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                            Update Production Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Production images can only be added after the artwork preview has been approved by the customer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Preview image handling
        const imageInput = document.getElementById('preview_image');
        const previewContainer = document.getElementById('preview-container');
        const previewImage = document.getElementById('preview-image');
        const removeButton = document.getElementById('remove-image');
        const dropzone = document.getElementById('dropzone');
        
        // Production image handling
        const productionImageInput = document.getElementById('production_image');
        const productionPreviewContainer = document.getElementById('production-preview-container');
        const productionPreviewImage = document.getElementById('production-preview-image');
        const removeProductionButton = document.getElementById('remove-production-image');
        const productionDropzone = document.getElementById('production-dropzone');
        
        // Preview uploaded image
        imageInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                    dropzone.classList.add('border-indigo-300', 'bg-indigo-50');
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
        
        // Remove preview image
        removeButton.addEventListener('click', function() {
            imageInput.value = '';
            previewContainer.classList.add('hidden');
            dropzone.classList.remove('border-indigo-300', 'bg-indigo-50');
        });
        
        // Preview uploaded production image
        if (productionImageInput) {
            productionImageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        productionPreviewImage.src = e.target.result;
                        productionPreviewContainer.classList.remove('hidden');
                        productionDropzone.classList.add('border-indigo-300', 'bg-indigo-50');
                    }
                    
                    reader.readAsDataURL(this.files[0]);
                }
            });
        }
        
        // Remove production preview image
        if (removeProductionButton) {
            removeProductionButton.addEventListener('click', function() {
                productionImageInput.value = '';
                productionPreviewContainer.classList.add('hidden');
                productionDropzone.classList.remove('border-indigo-300', 'bg-indigo-50');
            });
        }
        
        // Drag and drop functionality for preview image
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, preventDefaults, false);
            if (productionDropzone) {
                productionDropzone.addEventListener(eventName, preventDefaults, false);
            }
        });
        
        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }
        
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, highlight, false);
            if (productionDropzone) {
                productionDropzone.addEventListener(eventName, highlightProduction, false);
            }
        });
        
        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, unhighlight, false);
            if (productionDropzone) {
                productionDropzone.addEventListener(eventName, unhighlightProduction, false);
            }
        });
        
        function highlight() {
            dropzone.classList.add('border-indigo-300', 'bg-indigo-50');
        }
        
        function unhighlight() {
            dropzone.classList.remove('border-indigo-300', 'bg-indigo-50');
        }
        
        function highlightProduction() {
            productionDropzone.classList.add('border-indigo-300', 'bg-indigo-50');
        }
        
        function unhighlightProduction() {
            productionDropzone.classList.remove('border-indigo-300', 'bg-indigo-50');
        }
        
        dropzone.addEventListener('drop', handleDrop, false);
        if (productionDropzone) {
            productionDropzone.addEventListener('drop', handleProductionDrop, false);
        }
        
        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files && files.length) {
                imageInput.files = files;
                const event = new Event('change');
                imageInput.dispatchEvent(event);
            }
        }
        
        function handleProductionDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            
            if (files && files.length) {
                productionImageInput.files = files;
                const event = new Event('change');
                productionImageInput.dispatchEvent(event);
            }
        }
    });
</script>
@endpush
@endsection