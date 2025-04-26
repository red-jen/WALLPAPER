@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Artwork</h1>

        <form action="{{ route('artworks.store') }}" method="POST" class="bg-white rounded-lg shadow-md p-6" enctype="multipart/form-data">
            @csrf

            <div class="mb-6">
                <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                <input type="text" name="title" id="title" class="form-input w-full rounded-md @error('title') border-red-500 @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="form-textarea w-full rounded-md @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="width" class="block text-gray-700 text-sm font-bold mb-2">Width (cm)</label>
                    <input type="number" name="width" id="width" class="form-input w-full rounded-md @error('width') border-red-500 @enderror" value="{{ old('width') }}" min="1">
                    @error('width')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="height" class="block text-gray-700 text-sm font-bold mb-2">Height (cm)</label>
                    <input type="number" name="height" id="height" class="form-input w-full rounded-md @error('height') border-red-500 @enderror" value="{{ old('height') }}" min="1">
                    @error('height')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Artwork Image</label>
                <input type="file" name="image" id="image" class="form-input w-full rounded-md @error('image') border-red-500 @enderror" required>
                <p class="text-gray-500 text-xs mt-1">Upload an image of your artwork (JPEG, PNG, GIF - Max 2MB)</p>
                @error('image')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Paper</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($papers as $paper)
                            <div class="relative">
                                <input type="radio" name="paper_id" id="paper_{{ $paper->id }}" value="{{ $paper->id }}" class="hidden peer" required>
                                <label for="paper_{{ $paper->id }}" class="block p-4 border-2 rounded-lg cursor-pointer transition-all peer-checked:border-blue-500 hover:bg-gray-50">
                                    <img src="{{ asset('storage/' . $paper->image_path) }}" alt="{{ $paper->name }}" class="w-full h-32 object-cover rounded mb-2">
                                    <h4 class="font-semibold">{{ $paper->name }}</h4>
                                    <p class="text-sm text-gray-600">{{ $paper->size }}</p>
                                    <p class="text-sm text-gray-600">{{ $paper->thickness_with_unit }}</p>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('paper_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2">Select Design</label>
                    <div class="grid grid-cols-2 gap-4">
                        @foreach($designs as $design)
                            <div class="relative">
                                <input type="radio" name="design_id" id="design_{{ $design->id }}" value="{{ $design->id }}" class="hidden peer" required>
                                <label for="design_{{ $design->id }}" class="block p-4 border-2 rounded-lg cursor-pointer transition-all peer-checked:border-blue-500 hover:bg-gray-50">
                                    <img src="{{ asset('storage/' . $design->image_path) }}" alt="{{ $design->title }}" class="w-full h-32 object-cover rounded mb-2">
                                    <h4 class="font-semibold">{{ $design->title }}</h4>
                                    <p class="text-sm text-gray-600">By {{ $design->designer->name ?? 'Unknown Designer' }}</p>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('design_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('artworks.index') }}" class="text-gray-600 hover:text-gray-800">
                    Cancel
                </a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-6 rounded-lg">
                    Create Artwork
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Preview functionality could be added here
    // For example, showing how the paper and design would look combined
</script>
@endpush
@endsection 