@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">My Artworks</h1>
        <a href="{{ route('artworks.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg">
            Create New Artwork
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($artworks as $artwork)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <img src="{{ $artwork->getImageUrlAttribute() }}" alt="{{ $artwork->title }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $artwork->title }}</h3>
                    <p class="text-gray-600 mb-2">{{ Str::limit($artwork->description, 100) }}</p>
                    <div class="text-sm text-gray-500 mb-4">
                        <p>Dimensions: {{ $artwork->width ? $artwork->width . 'cm' : '--' }} × {{ $artwork->height ? $artwork->height . 'cm' : '--' }}</p>
                        <p>Paper: {{ $artwork->paper->name }}</p>
                        <p>Design: {{ $artwork->design->title }}</p>
                    </div>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('artworks.show', $artwork) }}" class="text-blue-500 hover:text-blue-600">
                            View Details
                        </a>
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
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">You haven't created any artworks yet.</p>
                <a href="{{ route('artworks.create') }}" class="text-blue-500 hover:text-blue-600 mt-2 inline-block">
                    Get started by creating your first artwork
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection 