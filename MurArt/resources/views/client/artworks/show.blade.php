@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('artworks.index') }}" class="text-blue-500 hover:text-blue-600">
                <i class="fas fa-arrow-left"></i> Back to Artworks
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6">
                    <img src="{{ $artwork->getImageUrlAttribute() }}" alt="{{ $artwork->title }}" class="w-full h-auto rounded-lg shadow-sm">
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Used Components</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium text-gray-800 mb-2">Paper</h4>
                                <img src="{{ asset('storage/' . $artwork->paper->image_path) }}" alt="{{ $artwork->paper->name }}" class="w-full h-32 object-cover rounded mb-2">
                                <p class="text-sm text-gray-600">{{ $artwork->paper->name }}</p>
                                <p class="text-sm text-gray-500">{{ $artwork->paper->size }}</p>
                            </div>
                            <div class="border rounded-lg p-4">
                                <h4 class="font-medium text-gray-800 mb-2">Design</h4>
                                <img src="{{ asset('storage/' . $artwork->design->image_path) }}" alt="{{ $artwork->design->title }}" class="w-full h-32 object-cover rounded mb-2">
                                <p class="text-sm text-gray-600">{{ $artwork->design->title }}</p>
                                <p class="text-sm text-gray-500">By {{ $artwork->design->designer->name ?? 'Unknown Designer' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-gray-50">
                    <div class="flex justify-between items-start mb-6">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $artwork->title }}</h1>
                        <div class="flex space-x-2">
                            <a href="{{ route('artworks.edit', $artwork) }}" class="text-yellow-500 hover:text-yellow-600">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('artworks.destroy', $artwork) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-600" onclick="return confirm('Are you sure you want to delete this artwork?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="prose max-w-none mb-6">
                        <p class="text-gray-600">{{ $artwork->description }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Dimensions</h3>
                            <p class="text-gray-800">{{ $artwork->width ? $artwork->width . 'cm' : '--' }} × {{ $artwork->height ? $artwork->height . 'cm' : '--' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Paper Type</h3>
                            <p class="text-gray-800">{{ $artwork->paper->name }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Design</h3>
                            <p class="text-gray-800">{{ $artwork->design->title }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-600">Created At</h3>
                            <p class="text-gray-800">{{ $artwork->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 