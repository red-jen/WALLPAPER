@extends('layouts.admin')

@section('title', 'Add New Wallpaper')

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
    .primary-badge {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background-color: #D4AF37;
        color: white;
        padding: 2px 8px;
        border-radius: 0.375rem;
        font-size: 0.75rem;
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
        <span class="text-charcoal">Add New Wallpaper</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Add New Wallpaper</h1>
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

<form action="{{ route('admin.wallpapers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <!-- Basic Information Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Basic Information</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title <span class="text-red-600">*</span></label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-600">*</span></label>
                    <select id="category_id" name="category_id" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mt-4">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="4" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">{{ old('description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Provide a detailed description of the wallpaper.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mt-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($) <span class="text-red-600">*</span></label>
                    <input type="number" id="price" name="price" value="{{ old('price') }}" step="0.01" min="0" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-1">Stock Quantity <span class="text-red-600">*</span></label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="width" class="block text-sm font-medium text-gray-700 mb-1">Width (pixels) <span class="text-red-600">*</span></label>
                    <input type="number" id="width" name="width" value="{{ old('width') }}" min="1" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                    <p class="mt-1 text-xs text-gray-500">Enter the wallpaper width in pixels</p>
                </div>
                
                <div>
                    <label for="height" class="block text-sm font-medium text-gray-700 mb-1">Height (pixels) <span class="text-red-600">*</span></label>
                    <input type="number" id="height" name="height" value="{{ old('height') }}" min="1" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                    <p class="mt-1 text-xs text-gray-500">Enter the wallpaper height in pixels</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-600">*</span></label>
                    <select id="status" name="status" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                        <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Images Section -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Wallpaper Images</h2>
        </div>
        <div class="p-6">
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Upload Images <span class="text-red-600">*</span></label>
                <input type="file" id="images" name="images[]" multiple accept="image/*" required
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-gold-light">
                <p class="mt-1 text-sm text-gray-500">Select multiple images at once. The first image will be the primary image unless specified below.</p>
            </div>
            
            <div id="preview-container" class="mt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 hidden">
                <!-- Preview images will be displayed here -->
            </div>
            
            <div class="mt-4">
                <label for="primary_image" class="block text-sm font-medium text-gray-700 mb-1">Primary Image</label>
                <select id="primary_image" name="primary_image" class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                    <option value="0">First image (default)</option>
                    <!-- Options will be added dynamically based on selected images -->
                </select>
                <p class="mt-1 text-sm text-gray-500">Select which image should be the primary display image.</p>
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
                                       {{ in_array($paper->id, old('paper_ids', [])) ? 'checked' : '' }}
                                       class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold">
                            </div>
                            <div class="ml-3 text-sm">
                                <label for="paper_{{ $paper->id }}" class="font-medium text-gray-700">{{ $paper->name }}</label>
                                <p class="text-gray-500">{{ $paper->type }}</p>
                                
                                <div class="mt-2 flex items-center">
                                    <input type="checkbox" id="recommended_{{ $paper->id }}" name="recommended_paper_ids[]" value="{{ $paper->id }}" 
                                           {{ in_array($paper->id, old('recommended_paper_ids', [])) ? 'checked' : '' }}
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
            Create Wallpaper
        </button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imagesInput = document.getElementById('images');
        const previewContainer = document.getElementById('preview-container');
        const primaryImageSelect = document.getElementById('primary_image');
        
        // Handle image preview
        if (imagesInput) {
            imagesInput.addEventListener('change', function() {
                previewContainer.innerHTML = '';
                primaryImageSelect.innerHTML = '<option value="0">First image (default)</option>';
                
                if (this.files.length > 0) {
                    previewContainer.classList.remove('hidden');
                    
                    Array.from(this.files).forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Create preview element
                            const previewDiv = document.createElement('div');
                            previewDiv.className = 'image-container';
                            
                            previewDiv.innerHTML = `
                                <img src="${e.target.result}" class="image-preview border border-gray-200" alt="Preview Image ${index + 1}">
                                ${index === 0 ? '<span class="primary-badge">Primary</span>' : ''}
                                <div class="mt-2">
                                    <input type="text" name="image_titles[${index}]" placeholder="Image title (optional)" 
                                           class="w-full text-sm rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                                </div>
                            `;
                            
                            previewContainer.appendChild(previewDiv);
                            
                            // Add option to primary image selector
                            const option = document.createElement('option');
                            option.value = index;
                            option.textContent = `Image ${index + 1}${index === 0 ? ' (default)' : ''}`;
                            option.selected = index === 0;
                            primaryImageSelect.appendChild(option);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                } else {
                    previewContainer.classList.add('hidden');
                }
            });
        }
        
        // When primary image selection changes, update preview badges
        primaryImageSelect.addEventListener('change', function() {
            const selectedIndex = parseInt(this.value);
            const previewImages = previewContainer.querySelectorAll('.image-container');
            
            previewImages.forEach((container, index) => {
                const badge = container.querySelector('.primary-badge');
                
                if (badge) {
                    badge.remove();
                }
                
                if (index === selectedIndex) {
                    const newBadge = document.createElement('span');
                    newBadge.className = 'primary-badge';
                    newBadge.textContent = 'Primary';
                    container.appendChild(newBadge);
                }
            });
        });
        
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