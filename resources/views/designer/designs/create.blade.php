@extends('layouts.admin')

@section('title', 'Create New Design')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('designer.designs.index') }}" class="hover:text-navy">My Designs</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Create New Design</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Create New Design</h1>
    <a href="{{ route('designer.designs.index') }}" 
        class="px-4 py-2 bg-gray-200 text-charcoal rounded-md font-medium hover:bg-gray-300 transition-colors flex items-center gap-2">
        <i class="fas fa-arrow-left"></i> Back to Designs
    </a>
</div>

<!-- Form Card -->
<div class="bg-white rounded-xl shadow-sm overflow-hidden">
    <div class="border-b border-gray-200 px-6 py-4">
        <h2 class="text-lg font-heading font-semibold text-navy">Design Details</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('designer.designs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-charcoal/70 mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="title" 
                        name="title" 
                        value="{{ old('title') }}" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent @error('title') border-red-500 @enderror" 
                        placeholder="Enter design title"
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
                            <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Design Image Upload -->
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-charcoal/70 mb-2">
                    Design Image <span class="text-red-500">*</span>
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gold transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-gold hover:text-gold/80 focus-within:outline-none focus-within:ring-2 focus-within:ring-gold">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" required accept="image/*">
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        <p id="selected-file" class="text-sm font-medium text-navy hidden mt-2"></p>
                    </div>
                </div>
                @error('image')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <!-- Optional Description -->
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-charcoal/70 mb-2">
                    Description <span class="text-gray-400">(optional)</span>
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent"
                    rows="4"
                    placeholder="Add details about your design..."
                >{{ old('description') }}</textarea>
            </div>
            
            <!-- Optional Style -->
            <div class="mb-6">
                <label for="style" class="block text-sm font-medium text-charcoal/70 mb-2">
                    Style <span class="text-gray-400">(optional)</span>
                </label>
                <input 
                    type="text" 
                    id="style" 
                    name="style" 
                    value="{{ old('style') }}" 
                    class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-2 focus:ring-gold focus:border-transparent" 
                    placeholder="Modern, Vintage, Abstract, etc."
                >
            </div>
            
            <!-- Buttons -->
            <div class="flex justify-end space-x-3 mt-8">
                <a href="{{ route('designer.designs.index') }}" 
                    class="px-5 py-2.5 bg-gray-200 text-charcoal rounded-md font-medium hover:bg-gray-300 transition-colors">
                    Cancel
                </a>
                <button 
                    type="submit" 
                    class="px-5 py-2.5 bg-gold text-navy rounded-md font-medium hover:bg-gold/90 transition-colors">
                    <i class="fas fa-upload mr-1"></i> Upload Design
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('image');
        const selectedFile = document.getElementById('selected-file');
        
        fileInput.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            if (fileName) {
                selectedFile.textContent = 'Selected file: ' + fileName;
                selectedFile.classList.remove('hidden');
            } else {
                selectedFile.classList.add('hidden');
            }
        });
    });
</script>
@endpush
@endsection