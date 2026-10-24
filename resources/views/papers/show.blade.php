@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<div class="container py-6">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-6">
            <a href="{{ route('papers.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Papers
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:w-1/2">
                    @if($paper->image_path)
                        <img src="{{ asset('storage/' . $paper->image_path) }}" 
                             alt="{{ $paper->name }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                            <svg class="w-32 h-32 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                
                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $paper->name }}</h1>
                    
                    @if($paper->price)
                        <div class="text-3xl font-bold text-indigo-600 mb-6">
                            {{ $paper->formatted_price }}
                        </div>
                    @endif
                    
                    @if($paper->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Description</h3>
                            <p class="text-gray-600">{{ $paper->description }}</p>
                        </div>
                    @endif
                    
                    <div class="space-y-4 mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Specifications</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Type</span>
                                <p class="text-gray-900">{{ $paper->type }}</p>
                            </div>
                            
                            @if($paper->thickness)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Thickness</span>
                                    <p class="text-gray-900">{{ $paper->thickness_with_unit }}</p>
                                </div>
                            @endif
                            
                            @if($paper->size)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Size</span>
                                    <p class="text-gray-900">{{ $paper->size }}</p>
                                </div>
                            @endif
                            
                            @if($paper->color)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Color</span>
                                    <p class="text-gray-900">{{ $paper->color }}</p>
                                </div>
                            @endif
                            
                            @if($paper->finish)
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Finish</span>
                                    <p class="text-gray-900">{{ $paper->finish }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($paper->usage)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Best Used For</h3>
                            <p class="text-gray-600">{{ $paper->usage }}</p>
                        </div>
                    @endif
                    
                    <div class="flex gap-4">
                        <a href="{{ route('designs.index') }}" 
                           class="flex-1 px-6 py-3 bg-indigo-600 text-white text-center rounded-md hover:bg-indigo-700 transition-colors">
                            Use This Paper
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
