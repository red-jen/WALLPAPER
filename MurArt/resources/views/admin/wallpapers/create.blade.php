@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Add New Wallpaper</h1>
        <a href="{{ route('admin.wallpapers.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
            <i class="fas fa-arrow-left fa-sm text-white-50"></i> Back to Wallpapers
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Wallpaper Details</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.wallpapers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title">Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
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
                                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="price">Price ($) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" min="0" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="stock">Stock Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- filepath: c:\Users\youco\OneDrive\Bureau\WALLPAPER\MurArt\resources\views\admin\wallpapers\create.blade.php -->

<!-- Add this after the price/stock row -->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="width">Width (pixels) <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('width') is-invalid @enderror" 
                   id="width" name="width" value="{{ old('width') }}" min="1" required>
            <small class="form-text text-muted">Enter the wallpaper width in pixels</small>
            @error('width')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="form-group">
            <label for="height">Height (pixels) <span class="text-danger">*</span></label>
            <input type="number" class="form-control @error('height') is-invalid @enderror" 
                   id="height" name="height" value="{{ old('height') }}" min="1" required>
            <small class="form-text text-muted">Enter the wallpaper height in pixels</small>
            @error('height')
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
                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                <option value="featured" {{ old('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="images">Wallpaper Images (Multiple) <span class="text-danger">*</span></label>
                            <input type="file" class="form-control-file @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" id="images" name="images[]" multiple accept="image/*" required>
                            <small class="form-text text-muted">You can select multiple images at once. The first image will be the primary image.</small>
                            @error('images')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            @error('images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
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
                                        <input class="form-check-input" type="checkbox" name="paper_ids[]" value="{{ $paper->id }}" id="paper_{{ $paper->id }}" {{ in_array($paper->id, old('paper_ids', [])) ? 'checked' : '' }}>
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
                    <button type="submit" class="btn btn-primary">Create Wallpaper</button>
                    <a href="{{ route('admin.wallpapers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection