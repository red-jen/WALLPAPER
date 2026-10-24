@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<div class="container py-6">
    <div class="max-w-7xl mx-auto px-4">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Paper Types</h1>
            <p class="mt-2 text-gray-600">Browse our selection of high-quality papers for your custom designs</p>
        </div>

        @if($papers->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($papers as $paper)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                        @if($paper->image_path)
                            <img src="{{ asset('storage/' . $paper->image_path) }}" 
                                 alt="{{ $paper->name }}" 
                                 class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $paper->name }}</h3>
                            
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center text-sm text-gray-600">
                                    <span class="font-medium mr-2">Type:</span>
                                    <span>{{ $paper->type }}</span>
                                </div>
                                
                                @if($paper->thickness)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span class="font-medium mr-2">Thickness:</span>
                                        <span>{{ $paper->thickness_with_unit }}</span>
                                    </div>
                                @endif
                                
                                @if($paper->finish)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span class="font-medium mr-2">Finish:</span>
                                        <span>{{ $paper->finish }}</span>
                                    </div>
                                @endif
                                
                                @if($paper->size)
                                    <div class="flex items-center text-sm text-gray-600">
                                        <span class="font-medium mr-2">Size:</span>
                                        <span>{{ $paper->size }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($paper->description)
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $paper->description }}</p>
                            @endif
                            
                            <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-200">
                                @if($paper->price)
                                    <span class="text-2xl font-bold text-indigo-600">{{ $paper->formatted_price }}</span>
                                @else
                                    <span class="text-sm text-gray-500">Contact for pricing</span>
                                @endif
                                
                                <a href="{{ route('papers.show', $paper) }}" 
                                   class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700 transition-colors">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-8">
                {{ $papers->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-md p-12 text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h2 class="mt-4 text-xl font-medium text-gray-900">No Paper Types Available</h2>
                <p class="mt-2 text-gray-500">Check back soon for our paper collection.</p>
                <div class="mt-6">
                    <a href="{{ url('/') }}" class="px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 inline-block">
                        Back to Home
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
