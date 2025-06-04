@extends('layouts.admin')

@section('title', 'Edit Wallpaper - ' . $wallpaper->title)

@section('styles')
<style>
    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 0.375rem;
    }
    .image-container {
        position: relative;
    }
    .image-container .actions {
        transition: all 0.2s ease;
    }
    .image-container:hover .actions {
        opacity: 1;
    }
    .primary-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }
</style>
@endsection

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.wallpapers.index') }}" class="hover:text-navy">Wallpapers</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Edit {{ $wallpaper->title }}</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Edit Wallpaper</h1>
    <a href="{{ route('admin.wallpapers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150">
        <i class="fas fa-arrow-left mr-2"></i> Back to Wallpapers
    </a>
</div>

@if($errors->any())
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle h-5 w-5 text-red-500"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Please fix the following errors:</h3>
                <ul class="mt-2 text-sm list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

<form action="{{ route('admin.wallpapers.update', $wallpaper) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Basic Information</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-600">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title', $wallpaper->title) }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-600">*</span></label>
                    <select id="category_id" name="category_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id', $wallpaper->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">{{ old('description', $wallpaper->description) }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Provide a detailed description of the wallpaper.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) <span class="text-red-600">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price', $wallpaper->price) }}" step="0.01" min="0" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity <span class="text-red-600">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $wallpaper->stock) }}" min="0" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-600">*</span></label>
                    <select id="status" name="status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                        <option value="draft" {{ old('status', $wallpaper->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $wallpaper->status) == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="featured" {{ old('status', $wallpaper->status) == 'featured' ? 'selected' : '' }}>Featured</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Current Images Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Current Images</h2>
        </div>
        <div class="p-6">
            @if($wallpaper->images->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($wallpaper->images as $image)
                        <div class="image-container">
                            <img src="{{ asset('storage/' . $image->image_path) }}" class="image-preview border border-gray-200" alt="{{ $image->title ?? 'Image' }}">
                            
                            @if($image->is_primary)
                                <span class="primary-badge bg-gold text-white text-xs px-2 py-1 rounded-md">Primary</span>
                            @endif
                            
                            <div class="mt-2 space-y-2">
                                <input type="text" name="existing_image_titles[{{ $image->id }}]" value="{{ $image->title }}" 
                                       class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50"
                                       placeholder="Image title">
                                
                                <div class="flex justify-between">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="delete_image_{{ $image->id }}" name="delete_image_ids[]" value="{{ $image->id }}" 
                                               class="h-4 w-4 text-gold border-gray-300 rounded focus:ring-gold">
                                        <label for="delete_image_{{ $image->id }}" class="ml-2 text-sm text-gray-700">Delete</label>
                                    </div>
                                    
                                    <div class="flex items-center">
                                        <input type="radio" id="primary_image_{{ $image->id }}" name="primary_image_id" value="{{ $image->id }}" 
                                               {{ $image->is_primary ? 'checked' : '' }}
                                               class="h-4 w-4 text-gold border-gray-300 focus:ring-gold">
                                        <label for="primary_image_{{ $image->id }}" class="ml-2 text-sm text-gray-700">Primary</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg">
                    <i class="fas fa-images text-5xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">No images available</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Add New Images Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Add New Images</h2>
        </div>
        <div class="p-6">
            <div id="new-images-container">
                <div class="mb-4">
                    <label for="new_images" class="block text-sm font-medium text-gray-700 mb-1">Upload New Images</label>
                    <input type="file" id="new_images" name="new_images[]" multiple accept="image/*" 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-gold-light">
                    <p class="mt-1 text-sm text-gray-500">You can select multiple images to upload at once. Maximum file size: 5MB per image.</p>
                </div>
                
                <div id="new-images-preview" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-4 hidden">
                    <!-- Preview images will be inserted here by JavaScript -->
                </div>
            </div>
        </div>
    </div>

    <!-- Compatible Papers Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Compatible Papers</h2>
        </div>
        <div class="p-6">
            <p class="mb-4 text-sm text-gray-500">Select which paper types are compatible with this wallpaper. You can also mark recommended papers.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($papers as $paper)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex h-5 items-center">
                                <input type="checkbox" id="paper_{{ $paper->id }}" name="paper_ids[]" value="{{ $paper->id }}" 
                                       {{ in_array($paper->id, $selectedPaperIds) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="paper_{{ $paper->id }}" class="font-medium text-gray-700">{{ $paper->name }}</label>
                                <p class="text-gray-500">{{ $paper->description }}</p>
                                
                                <div class="mt-2 flex items-center">
                                    <input type="checkbox" id="recommended_{{ $paper->id }}" name="recommended_paper_ids[]" value="{{ $paper->id }}" 
                                           {{ in_array($paper->id, $recommendedPaperIds) ? 'checked' : '' }}
                                           class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold">
                                    <label for="recommended_{{ $paper->id }}" class="ml-2 block text-sm text-gray-700">
                                        Mark as Recommended
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Form Actions -->
    <div class="flex justify-end space-x-3">
        <a href="{{ route('admin.wallpapers.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150">
            Cancel
        </a>
        <button type="submit" class="px-6 py-3 bg-gold hover:bg-gold-light text-white rounded-lg transition-colors duration-150">
            Update Wallpaper
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newImagesInput = document.getElementById('new_images');
        const previewContainer = document.getElementById('new-images-preview');
        let newImageCount = 0;
        
        // Add preview for new images
        if (newImagesInput) {
            newImagesInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                
                if (this.files.length > 0) {
                    previewContainer.classList.remove('hidden');
                    
                    Array.from(this.files).forEach((file, index) => {
                        const reader = new FileReader();
                        const imageIndex = newImageCount + index;
                        
                        reader.onload = function(e) {
                            const imageContainer = document.createElement('div');
                            imageContainer.className = 'image-container';
                            imageContainer.innerHTML = `
                                <img src="${e.target.result}" class="image-preview border border-gray-200" alt="New Image ${imageIndex + 1}">
                                <div class="mt-2 space-y-2">
                                    <input type="text" name="new_image_titles[${index}]" class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" placeholder="Image title">
                                    <div class="flex justify-center">
                                        <div class="flex items-center">
                                            <input type="radio" id="primary_new_image_${index}" name="primary_image_id" value="-${index + 1}" class="h-4 w-4 text-gold border-gray-300 focus:ring-gold">
                                            <label for="primary_new_image_${index}" class="ml-2 text-sm text-gray-700">Set as Primary</label>
                                        </div>
                                    </div>
                                </div>
                            `;
                            previewContainer.appendChild(imageContainer);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                    
                    newImageCount += this.files.length;
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        }
        
        // Ensure at least one paper is selected when a recommended paper is checked
        const recommendedPaperCheckboxes = document.querySelectorAll('input[name="recommended_paper_ids[]"]');
        recommendedPaperCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (this.checked) {
                    const paperId = this.value;
                    const paperCheckbox = document.getElementById(`paper_${paperId}`);
                    if (paperCheckbox && !paperCheckbox.checked) {
                        paperCheckbox.checked = true;
                    }
                }
            });
        });
        
        // Uncheck recommended when paper is unchecked
        const paperCheckboxes = document.querySelectorAll('input[name="paper_ids[]"]');
        paperCheckboxes.forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                if (!this.checked) {
                    const paperId = this.value;
                    const recommendedCheckbox = document.getElementById(`recommended_${paperId}`);
                    if (recommendedCheckbox && recommendedCheckbox.checked) {
                        recommendedCheckbox.checked = false;
                    }
                }
            });
        });
    });
</script>
@endpush
@endsection