@extends('layouts.admin')

@section('styles')
<style>
    .image-container {
        position: relative;
        display: inline-block;
        margin: 10px;
    }
    .image-preview {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 4px;
        padding: 3px;
    }
    .image-actions {
        margin-top: 5px;
        text-align: center;
    }
    .primary-badge {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #4e73df;
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 10px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Wallpaper</h1>
        <a href="{{ route('admin.wallpapers.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Wallpapers
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Wallpaper Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.wallpapers.update', $wallpaper) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $wallpaper->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="category_id">Category <span class="text-danger">*</span></label>
                            <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ old('category_id', $wallpaper->category_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $wallpaper->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $wallpaper->price) }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', $wallpaper->stock) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="draft" {{ old('status', $wallpaper->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status', $wallpaper->status) == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="featured" {{ old('status', $wallpaper->status) == 'featured' ? 'selected' : '' }}>Featured</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="new_images">Add New Images</label>
                            <input type="file" class="form-control-file @error('new_images') is-invalid @enderror @error('new_images.*') is-invalid @enderror" id="new_images" name="new_images[]" multiple accept="image/*">
                            <small class="form-text text-muted">You can select multiple new images to add to this wallpaper.</small>
                            @error('new_images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('new_images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Current Images Section -->
                <div class="form-group mt-4">
                    <label>Current Images</label>
                    <div class="border rounded p-3">
                        @if($wallpaper->images->count() > 0)
                            <div class="d-flex flex-wrap">
                                @foreach($wallpaper->images as $image)
                                    <div class="image-container">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" class="image-preview" alt="{{ $image->title ?? 'Image' }}">
                                        
                                        @if($image->is_primary)
                                            <span class="primary-badge">Primary</span>
                                        @endif
                                        
                                        <div class="image-actions">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="delete_image_{{ $image->id }}" name="delete_image_ids[]" value="{{ $image->id }}">
                                                <label class="custom-control-label" for="delete_image_{{ $image->id }}">Delete</label>
                                            </div>
                                            
                                            <div class="custom-control custom-radio mt-1">
                                                <input type="radio" class="custom-control-input" id="primary_image_{{ $image->id }}" name="primary_image_id" value="{{ $image->id }}" {{ $image->is_primary ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="primary_image_{{ $image->id }}">Make Primary</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-center mb-0">No images available</p>
                        @endif
                    </div>
                </div>
                
                <!-- Compatible Papers Section -->
                <div class="form-group mt-4">
                    <label>Compatible Papers</label>
                    <div class="border rounded p-3">
                        <div class="row">
                            @foreach($papers as $paper)
                                <div class="col-md-6 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="paper_ids[]" value="{{ $paper->id }}" id="paper_{{ $paper->id }}" 
                                            {{ in_array($paper->id, $selectedPaperIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="paper_{{ $paper->id }}">
                                            {{ $paper->name }} ({{ $paper->type }})
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Wallpaper</button>
                    <a href="{{ route('admin.wallpapers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection