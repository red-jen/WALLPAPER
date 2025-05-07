@extends('layouts.admin')

@section('title', 'Create Paper Type')

@section('content')
<!-- Breadcrumbs -->
<div class="mb-6">
    <div class="flex items-center text-sm text-charcoal/70">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-navy">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.papers.index') }}" class="hover:text-navy">Papers</a>
        <span class="mx-2">/</span>
        <span class="text-charcoal">Create Paper Type</span>
    </div>
</div>

<!-- Header -->
<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
    <h1 class="text-3xl font-heading font-bold text-navy mb-4 sm:mb-0">Create Paper Type</h1>
    <a href="{{ route('admin.papers.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150">
        <i class="fas fa-arrow-left mr-2"></i> Back to Paper Types
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

<form action="{{ route('admin.papers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    
    <!-- Basic Information -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Paper Details</h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-600">*</span></label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                </div>
                
                <div>
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-1">Paper Type <span class="text-red-600">*</span></label>
                    <select id="type" name="type" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50" required>
                        <option value="">Select Paper Type</option>
                        @foreach($paperTypes as $value => $label)
                            <option value="{{ $value }}" {{ old('type') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div>
                    <label for="thickness" class="block text-sm font-medium text-gray-700 mb-1">Thickness (GSM)</label>
                    <input type="number" id="thickness" name="thickness" value="{{ old('thickness') }}" min="1" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                    <p class="mt-1 text-xs text-gray-500">Measured in grams per square meter (GSM)</p>
                </div>
                
                <div>
                    <label for="size" class="block text-sm font-medium text-gray-700 mb-1">Paper Size</label>
                    <select id="size" name="size" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                        <option value="">Select Paper Size</option>
                        @foreach($paperSizes as $value => $label)
                            <option value="{{ $value }}" {{ old('size') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price ($)</label>
                    <input type="number" step="0.01" min="0" id="price" name="price" value="{{ old('price') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                <div>
                    <label for="color" class="block text-sm font-medium text-gray-700 mb-1">Color</label>
                    <input type="text" id="color" name="color" value="{{ old('color') }}" 
                           class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                    <p class="mt-1 text-xs text-gray-500">E.g., White, Cream, Colored, etc.</p>
                </div>
                
                <div>
                    <label for="finish" class="block text-sm font-medium text-gray-700 mb-1">Finish</label>
                    <select id="finish" name="finish" 
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">
                        <option value="">Select Finish</option>
                        @foreach($paperFinishes as $value => $label)
                            <option value="{{ $value }}" {{ old('finish') == $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Additional Information -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="font-heading font-semibold text-lg text-navy">Additional Information</h2>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Paper Image</label>
                <div class="mt-1 flex items-center">
                    <input type="file" id="image" name="image" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-medium file:bg-gold file:text-white hover:file:bg-gold-light">
                </div>
                <p class="mt-1 text-xs text-gray-500">Upload an image of the paper (JPEG, PNG, GIF, max 2MB)</p>
            </div>
            
            <div class="mb-6">
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-6">
                <label for="usage" class="block text-sm font-medium text-gray-700 mb-1">Recommended Usage</label>
                <textarea id="usage" name="usage" rows="3" 
                          class="w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring focus:ring-gold focus:ring-opacity-50">{{ old('usage') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Describe what this paper type is best suited for</p>
            </div>
            
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                          class="h-4 w-4 rounded border-gray-300 text-gold focus:ring-gold">
                </div>
                <div class="ml-3 text-sm">
                    <label for="is_active" class="font-medium text-gray-700">Active</label>
                    <p class="text-gray-500">When checked, this paper will be available for selection.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Form Actions -->
    <div class="flex justify-end space-x-3">
        <a href="{{ route('admin.papers.index') }}" class="px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-lg transition-colors duration-150">
            Cancel
        </a>
        <button type="submit" class="px-6 py-3 bg-gold hover:bg-gold-light text-white rounded-lg transition-colors duration-150">
            Create Paper Type
        </button>
    </div>
</form>
@endsection