@extends('layouts.admin')

@section('title', 'Edit Design - ' . $design->title)

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('designer.designs.index') }}" class="hover:text-navy">My Designs</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Edit Design</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">
        Edit Design
    </h1>
    <div class="flex flex-wrap gap-3">
        <a href="{{ route('designer.designs.show', $design) }}" 
            class="px-4 py-2 bg-navy text-white rounded-md font-medium hover:bg-navy/90 transition-colors flex items-center gap-2">
            <i class="fas fa-eye"></i> View
        </a>
        <a href="{{ route('designer.designs.index') }}" 
            class="px-4 py-2 bg-gray-200 text-charcoal rounded-md font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>
</div>

@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-800 px-4 py-3 rounded-md mb-6 flex justify-between items-center">
    <div>{{ session('success') }}</div>
    <button type="button" class="text-green-800" onclick="this.parentElement.remove()">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Form - Left Column -->
    <div class="lg:col-span-2 space-y-6">
        <form action="{{ route('designer.designs.update', $design) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <!-- Design Details Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                    <h2 class="text-lg font-heading font-semibold text-navy">Design Details</h2>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $design->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($design->status ?? 'Draft') }}
                    </span>
                </div>
                
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-charcoal/70 mb-2">
                                Title <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                value="{{ old('title', $design->title) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent @error('title') border-red-500 @enderror"
                                required
                            >
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Category -->
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-charcoal/70 mb-2">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="category_id" 
                                name="category_id" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent @error('category_id') border-red-500 @enderror"
                                required
                            >
                                <option value="">Select Category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id', $design->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-charcoal/70 mb-2">
                                Price ($) <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                step="0.01" 
                                min="0" 
                                id="price" 
                                name="price" 
                                value="{{ old('price', $design->price) }}" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent @error('price') border-red-500 @enderror"
                                required
                            >
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-charcoal/70 mb-2">
                                Status
                            </label>
                            <select 
                                id="status" 
                                name="status" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent"
                            >
                                <option value="draft" {{ old('status', $design->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $design->status) == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                    </div>
                    
                    <!-- Tags -->
                    <div>
                        <label for="tags" class="block text-sm font-medium text-charcoal/70 mb-2">
                            Tags
                        </label>
                        <select 
                            id="tags" 
                            name="tags[]" 
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent"
                            multiple
                        >
                            @foreach($tags ?? [] as $id => $name)
                                <option value="{{ $id }}" {{ in_array($id, old('tags', $design->tags->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                        <p class="text-sm text-gray-500 mt-1">Select multiple tags or type to create new ones</p>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-charcoal/70 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea 
                            id="description" 
                            name="description" 
                            rows="5"
                            class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent @error('description') border-red-500 @enderror"
                        >{{ old('description', $design->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Design Image Card -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="border-b border-gray-200 px-6 py-4">
                    <h2 class="text-lg font-heading font-semibold text-navy">Design Image</h2>
                </div>
                
                <div class="p-6">
                    <!-- Primary Image -->
                    <div>
                        <label class="block text-sm font-medium text-charcoal/70 mb-3">
                            Image
                        </label>
                        <div class="flex flex-col sm:flex-row gap-6">
                            <!-- Current Image Preview -->
                            <div class="flex-shrink-0">
                                <img 
                                    src="{{ asset('storage/' . $design->image_path) }}" 
                                    alt="{{ $design->title }}" 
                                    class="h-40 w-40 object-cover rounded-lg shadow-sm"
                                    id="primary-image-preview"
                                >
                            </div>
                            
                            <!-- Upload New Image -->
                            <div class="flex-grow">
                                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gold transition-colors">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600">
                                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-gold hover:text-gold/80">
                                                <span>Upload new image</span>
                                                <input id="image" name="image" type="file" class="sr-only" accept="image/*">
                                            </label>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                        <p id="selected-primary-file" class="text-sm font-medium text-navy hidden mt-2"></p>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">Leave blank to keep the current image</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Update Button - Hidden here, will place in sidebar card -->
            <button id="main-update-btn" type="submit" class="hidden"></button>
        </form>
    </div>
    
    <!-- Right Column - Preview and Actions -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Preview Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-heading font-semibold text-navy">Preview</h2>
            </div>
            <div class="p-6 text-center">
                <img 
                    src="{{ asset('storage/' . $design->image_path) }}" 
                    alt="{{ $design->title }}" 
                    class="h-48 w-full object-cover rounded-lg mb-4 mx-auto"
                    id="preview-image"
                >
                <h3 class="text-lg font-heading font-semibold text-navy" id="preview-title">{{ $design->title }}</h3>
                <p class="text-sm text-charcoal/60 mt-1" id="preview-category">{{ $design->category->name ?? 'Category' }}</p>
                <p class="text-lg font-bold text-navy mt-2" id="preview-price">${{ number_format($design->price, 2) }}</p>
            </div>
        </div>
        
        <!-- Actions Card -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="border-b border-gray-200 px-6 py-4">
                <h2 class="text-lg font-heading font-semibold text-navy">Actions</h2>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-sm text-charcoal/70">Last Updated</p>
                    <p class="font-medium">{{ $design->updated_at->format('F j, Y \a\t g:i a') }}</p>
                    <p class="text-xs text-charcoal/60 mt-1">Created: {{ $design->created_at->format('F j, Y') }}</p>
                </div>
                
                <div class="border-t border-gray-100 pt-4">
                    <button 
                        type="button" 
                        onclick="document.getElementById('main-update-btn').click();"
                        class="w-full py-3 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-save"></i>
                        Update Design
                    </button>
                    
                    <a href="{{ route('designer.designs.index') }}" class="w-full py-2.5 bg-gray-200 text-charcoal rounded-md font-medium hover:bg-gray-300 transition-colors flex items-center justify-center gap-2 mt-3">
                        Cancel
                    </a>
                </div>
                
                <div class="border-t border-gray-100 pt-4">
                    <button 
                        type="button"
                        onclick="document.getElementById('delete-modal').classList.remove('hidden')"
                        class="w-full py-2.5 bg-red-500 text-white rounded-md font-medium hover:bg-red-600 transition-colors flex items-center justify-center gap-2"
                    >
                        <i class="fas fa-trash"></i>
                        Delete Design
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-modal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="document.getElementById('delete-modal').classList.add('hidden')"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation-triangle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Design</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                Are you sure you want to delete this design? This action cannot be undone.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form action="{{ route('designer.designs.destroy', $design) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                </form>
                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" onclick="document.getElementById('delete-modal').classList.add('hidden')">
                    Cancel
                </button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Select2
        $('#tags').select2({
            placeholder: 'Select tags or type to create new ones',
            tags: true
        });
        
        // Primary image preview
        const primaryImageInput = document.getElementById('image');
        const primaryImagePreview = document.getElementById('primary-image-preview');
        const previewImage = document.getElementById('preview-image');
        const selectedPrimaryFile = document.getElementById('selected-primary-file');
        
        if (primaryImageInput) {
            primaryImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        primaryImagePreview.src = e.target.result;
                        previewImage.src = e.target.result;
                        selectedPrimaryFile.textContent = 'Selected: ' + file.name;
                        selectedPrimaryFile.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Preview updates
        const titleInput = document.getElementById('title');
        const categorySelect = document.getElementById('category_id');
        const priceInput = document.getElementById('price');
        const previewTitle = document.getElementById('preview-title');
        const previewCategory = document.getElementById('preview-category');
        const previewPrice = document.getElementById('preview-price');
        
        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value;
        });
        
        categorySelect.addEventListener('change', function() {
            previewCategory.textContent = this.options[this.selectedIndex].text;
        });
        
        priceInput.addEventListener('input', function() {
            const price = parseFloat(this.value) || 0;
            previewPrice.textContent = '$' + price.toFixed(2);
        });
    });
</script>
@endpush
@endsection