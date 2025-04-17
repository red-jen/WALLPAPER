@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Edit Design</span>
                        <a href="{{ route('designer.designs.index') }}" class="btn btn-sm btn-secondary">Back to Designs</a>
                    </div>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('designer.designs.update', $design) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-right">Title</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title', $design->title) }}" required autofocus>
                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-right">Description</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" rows="4">{{ old('description', $design->description) }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="image" class="col-md-4 col-form-label text-md-right">Design Image</label>
                            <div class="col-md-6">
                                @if($design->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="img-thumbnail" style="max-height: 150px;">
                                    </div>
                                @endif
                                <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image">
                                <small class="text-muted">Leave empty to keep current image. Supported formats: JPG, PNG, GIF (max 2MB)</small>
                                @error('image')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <label for="status" class="col-md-4 col-form-label text-md-right">Status</label>
                            <div class="col-md-6">
                                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                                    <option value="draft" {{ (old('status', $design->status) == 'draft') ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ (old('status', $design->status) == 'published') ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ (old('status', $design->status) == 'archived') ? 'selected' : '' }}>Archived</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Update Design
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection